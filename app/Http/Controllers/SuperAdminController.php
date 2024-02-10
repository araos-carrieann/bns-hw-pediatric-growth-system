<?php


namespace App\Http\Controllers;

use App\Models\ChildHealthRecord;
use App\Models\HealthWorker;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\ChildPersonalInformation;
use App\Export\ExportChildRecord;
use App\Export\ExportChildRecordPDF;
use Barryvdh\DomPDF\PDF;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function superAdminAccountList()
    {
        try {
            $adminAccounts = HealthWorker::where('role', 'admin')->paginate(6);
            if ($adminAccounts->isEmpty()) {
                $adminAccounts = null; // Set to null if there are no records
            }

            return view('super-admin.superAdminAccount', compact('adminAccounts'));
        } catch (\Exception $e) {
            Log::error('Error in BHWChildController@index', ['error' => $e->getMessage()]);
            abort(500, 'Internal Server Error');
        }
    }
    public function tableRecord()
    {
        try {
            $healthWorkerId = session('userId');

            $data = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
                ->select('child_personal_information.*', 'child_health_records.*')
                ->orderBy('child_health_records.created_at', 'DESC')
                ->get(); // Execute the query and fetch the data

            return view('super-admin.superAdminRecord', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error in BHWChildController@index', ['error' => $e->getMessage()]);
            // You can handle the error in a way that makes sense for your application
            abort(500, 'Internal Server Error');
        }
    }


    public function filter(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $filteredData = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
            ->select('child_personal_information.*', 'child_health_records.*')
            ->whereBetween('child_health_records.created_at', [$startDate, $endDate])
            ->orderBy('child_health_records.created_at', 'DESC')
            ->get(); // Execute the query and fetch the data

        return view('super-admin.superAdminRecordTable', compact('filteredData'));
    }

    public function reset()
    {
        return redirect()->route('super-admin.tableRecord');
    }

    public function exportPDF(Request $request)
    {
        $startDate = $request->input('start_date', null);
        $endDate = $request->input('end_date', null);

        Log::info('Export Type: PDF');
        Log::info('Export Dates: ' . $startDate . ' to ' . $endDate);

        // Temporarily log the session data to ensure correctness
        Log::info('LoggedUser: ' . session('LoggedUser'));

        $exportData = new ExportChildRecordPDF($startDate, $endDate);
        $data = $exportData->collection(); // Get the data

        // Temporarily log the retrieved data to debug
        Log::info('Retrieved Data: ' . json_encode($data));

        // PDF Export Logic
        $pdf = app(PDF::class);
        $pdf->loadView('modal.pdfLayout', compact('data'));

        return $pdf->download('ChildRecord_' . $startDate . 'to' . $endDate . '.pdf');
    }


    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', null);
        $endDate = $request->input('end_date', null);

        Log::info('Export Type: Excel');
        Log::info('Export Dates: ' . $startDate . ' to ' . $endDate);

        $exportData = new ExportChildRecord($startDate, $endDate);

        // Excel Export
        return Excel::download($exportData, 'ChildRecord_' . $startDate . 'to' . $endDate . '.xlsx');
    }


    public function charts()
    {
        $healthWorkerBrgy = session('UserBrgy');
        $countsByAge = ChildHealthRecord::select('age', DB::raw('count(*) as count'))
            ->groupBy('age')
            ->get();

        $totalAgeRecords = $countsByAge->sum('count');
        $countsByAge->each(function ($item) use ($totalAgeRecords) {
            $item->percentage = ($item->count / $totalAgeRecords) * 100;
        });

        // Fetch the count of children for each BMI classification
        $countsByBMI = ChildHealthRecord::select('bmi_classification', DB::raw('count(*) as count'))
            ->groupBy('bmi_classification')
            ->get();

        // Fetch the count of children for each gender
        $countsBySex = ChildPersonalInformation::select('sex', DB::raw('count(*) as count'))
            ->groupBy('sex')
            ->get();

        // Calculate percentage for each gender
        $totalRecords = $countsBySex->sum('count');
        $countsBySex->each(function ($item) use ($totalRecords) {
            $item->percentage = ($item->count / $totalRecords) * 100;
        });

        // Fetch BMI chart data
        $currentYear = now()->year;
        $lastFourYears = range($currentYear - 3, $currentYear);

        $bmiCategories = ['Underweight', 'Normal Weight', 'Overweight', 'Obese'];

        $bmiChartData = [
            'labels' => $lastFourYears, // Years as labels
            'datasets' => [],
        ];

        foreach ($bmiCategories as $category) {
            $counts = ChildHealthRecord::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as count'))
                ->where('bmi_classification', $category)
                ->whereIn(DB::raw('YEAR(created_at)'), $lastFourYears)
                ->groupBy(DB::raw('YEAR(created_at)'))
                ->pluck('count', 'year');

            // Append data for each category to the datasets array
            $bmiChartData['datasets'][] = [
                'label' => $category,
                'backgroundColor' => $this->generateRandomColor(),
                'data' => array_map('intval', $counts->toArray()),
            ];
        }
        $countRegisteredChild = ChildPersonalInformation::select(DB::raw('count(*) as count'))
            ->value('count');

        // Check if any results were returned
        if ($countRegisteredChild === null) {
            $countRegisteredChild = 0; // Set count to 0 if no records found
        }


        $countRegisteredBHW = HealthWorker::where('role', 'bhw-user')
            ->where('status', 'active')
            ->select(DB::raw('count(*) as count'))
            ->value('count');

        // Check if any results were returned
        if ($countRegisteredBHW === null) {
            $countRegisteredBHW = 0; // Set count to 0 if no records found
        }

        $countRegisteredBNS = HealthWorker::where('role', 'admin')
        ->where('status', 'active')
        ->select(DB::raw('count(*) as count'))
        ->value('count');

    // Check if any results were returned
    if ($countRegisteredBNS === null) {
        $countRegisteredBNS = 0; // Set count to 0 if no records found
    }

        return view('super-admin.superAdminDash', compact('countsByAge', 'countsByBMI', 'countsBySex', 'bmiChartData', 'countRegisteredChild', 'countRegisteredBHW', 'countRegisteredBNS'));
    }
    private function generateRandomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}
