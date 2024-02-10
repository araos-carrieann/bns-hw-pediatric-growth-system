<?php


namespace App\Http\Controllers;

use App\Models\HealthWorker;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\ChildPersonalInformation;
use App\Models\ChildHealthRecord;
use App\Export\ExportChildRecord;
use Barryvdh\DomPDF\PDF;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{



    public function adminAccountList()
    {
        try {
            $healthWorkerBrgy = session('UserBrgy');
    
            $bhwAccounts = HealthWorker::where('role', 'bhw-user')
                ->where('barangay', $healthWorkerBrgy)
                ->paginate(6); // Adjust the number per page as needed
    
            if ($bhwAccounts->isEmpty()) {
                $bhwAccounts = null; // Set to null if there are no records
            }
    
            return view('admin.adminAccount', compact('bhwAccounts'));
        } catch (\Exception $e) {
            Log::error('Error in BHWChildController@adminAccountList', ['error' => $e->getMessage()]);
            dd($e->getMessage());
            abort(500, 'Internal Server Error');
        }
    }
    

    public function tableRecord()
    {
        try {
            $healthWorkerId = session('LoggedUser');
            $healthWorkerBrgy = session('UserBrgy');

            $data = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
                ->select('child_personal_information.*', 'child_health_records.*')
                ->get(); // Execute the query and fetch the data

            return view('admin.adminRecord', compact('data'));
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
            ->get(); // Execute the query and fetch the data

        return view('admin.adminRecordTable', compact('filteredData'));
    }

    public function reset()
    {
        return redirect()->route('admin.tableRecord');
    }

    public function exportPDF(Request $request)
    {
        $startDate = $request->input('start_date', null);
        $endDate = $request->input('end_date', null);

        Log::info('Export Type: PDF');
        Log::info('Export Dates: ' . $startDate . ' to ' . $endDate);

        $exportData = new ExportChildRecord($startDate, $endDate);
        $data = $exportData->collection(); // Get the data

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

        $countsByAge = ChildHealthRecord::join('child_personal_information', 'child_health_records.child_id', '=', 'child_personal_information.id')
            ->where('barangay', $healthWorkerBrgy)->groupBy('age')
            ->select('age', DB::raw('count(*) as count'))
            ->get();

        $totalAgeRecords = $countsByAge->sum('count');
        $countsByAge->each(function ($item) use ($totalAgeRecords) {
            $item->percentage = ($item->count / $totalAgeRecords) * 100;
        });

        // Fetch the count of children for each BMI classification
        $countsByBMI = ChildHealthRecord::join('child_personal_information', 'child_health_records.child_id', '=', 'child_personal_information.id')
            ->where('barangay', $healthWorkerBrgy)->groupBy('bmi_classification')
            ->select('bmi_classification', DB::raw('count(*) as count'))
            ->get();

        // Fetch the count of children for each gender
        $countsBySex = ChildPersonalInformation::where('barangay', $healthWorkerBrgy)->groupBy('sex')
            ->select('sex', DB::raw('count(*) as count'))
            ->get();

        $countsBySex->each(function ($item) {
            $item->count = $item->count; // Keep only the count value
        });


        $currentYear = now()->year;
        $lastFourYears = range($currentYear - 3, $currentYear);

        $bmiCategories = ['Underweight', 'Normal Weight', 'Overweight', 'Obese'];

        $bmiChartData = [
            'labels' => $lastFourYears, // Years as labels
            'datasets' => [],
        ];

        foreach ($bmiCategories as $category) {
            $counts = ChildHealthRecord::join('child_personal_information', 'child_health_records.child_id', '=', 'child_personal_information.id')
                ->where('barangay', $healthWorkerBrgy)->where('bmi_classification', $category)
                ->whereIn(DB::raw('YEAR(child_health_records.created_at)'), $lastFourYears)
                ->groupBy(DB::raw('YEAR(child_health_records.created_at)'))
                ->select(DB::raw('YEAR(child_health_records.created_at) as year'), DB::raw('count(*) as count'))
                ->pluck('count', 'year');

            $bmiChartData['datasets'][] = [
                'label' => $category,
                'backgroundColor' => $this->generateRandomColor(),
                'data' => array_values($counts->toArray()), // Use array_values to reset keys
            ];
        }


        $countRegisteredChild = ChildPersonalInformation::where('barangay', $healthWorkerBrgy)
        ->groupBy('barangay')
        ->select(DB::raw('count(*) as count'))
        ->value('count');
    
    // Check if any results were returned
    if ($countRegisteredChild === null) {
        $countRegisteredChild = 0; // Set count to 0 if no records found
    }
    

            $countRegisteredBHW = HealthWorker::where('role', 'bhw-user')
            ->where('status', 'active')
            ->where('barangay', $healthWorkerBrgy)
            ->groupBy('barangay')
            ->select(DB::raw('count(*) as count'))
            ->value('count');
        
        // Check if any results were returned
        if ($countRegisteredBHW === null) {
            $countRegisteredBHW = 0; // Set count to 0 if no records found
        }
        


        return view('admin.adminDash', compact('countsByAge', 'countsByBMI', 'countsBySex', 'bmiChartData', 'countRegisteredChild', 'countRegisteredBHW'));
    }

    private function generateRandomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}
