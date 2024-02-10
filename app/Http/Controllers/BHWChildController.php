<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\ChildPersonalInformation;
use App\Models\ChildHealthRecord;
use Illuminate\Support\Facades\Log;
use App\Export\ExportChildRecord;
use Barryvdh\DomPDF\PDF;


class BHWChildController extends Controller
{

    public function inputTable()
    {
        try {
            $healthWorkerId = session('LoggedUser');

            $combinedData = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
                ->select('child_personal_information.*', 'child_health_records.*')
                ->where('child_health_records.health_worker_id', $healthWorkerId)
                ->get(); // Execute the query and fetch the data

            Log::info('Data retrieved successfully in BHWChildController@index', ['healthWorkerId' => $healthWorkerId]);
            return view('bhw-user.bhwInputTable', compact('combinedData'));
        } catch (\Exception $e) {
            Log::error('Error in BHWChildController@index', ['error' => $e->getMessage()]);
            // You can handle the error in a way that makes sense for your application
            abort(500, 'Internal Server Error');
        }
    }
    public function tableRecord()
    {
        try {
            $healthWorkerId = session('LoggedUser');

            $data = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
                ->select('child_personal_information.*', 'child_health_records.*')
                ->where('child_health_records.health_worker_id', $healthWorkerId)
                ->get(); // Execute the query and fetch the data

            Log::info('Data retrieved successfully in BHWChildController@index', ['healthWorkerId' => $healthWorkerId]);
            return view('bhw-user.bhwRecord', compact('data'));
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
        $healthWorkerId = session('LoggedUser');

        $filteredData = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
            ->select('child_personal_information.*', 'child_health_records.*')
            ->where('child_health_records.health_worker_id', $healthWorkerId)
            ->whereBetween('child_health_records.created_at', [$startDate, $endDate])
            ->get(); // Execute the query and fetch the data

        return view('bhw-user.bhwRecordTable', compact('filteredData'));
    }

    public function reset()
    {
        return redirect()->route('bhw-child.tableRecord');
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
        $pdf->loadView('modal.pdfLayout', compact('data'))->setPaper('a4', 'landscape');
    
        return $pdf->download('ChildRecord_' . $startDate . 'to' . $endDate .'.pdf');
    }
    
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', null);
        $endDate = $request->input('end_date', null);
    
        Log::info('Export Type: Excel');
        Log::info('Export Dates: ' . $startDate . ' to ' . $endDate);
    
        $exportData = new ExportChildRecord($startDate, $endDate);
    
        // Excel Export
        return Excel::download($exportData, 'ChildRecord_' . $startDate . 'to' . $endDate .'.xlsx');
    }
    public function charts()
    {
        $healthWorkerId = session('userId');

        $countsByAge = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
        ->select('age', DB::raw('count(*) as count'))
        ->where('child_health_records.health_worker_id', $healthWorkerId)
            ->groupBy('age')
            ->get();

        $totalAgeRecords = $countsByAge->sum('count');
        $countsByAge->each(function ($item) use ($totalAgeRecords) {
            $item->percentage = ($item->count / $totalAgeRecords) * 100;
        });

        // Fetch the count of children for each BMI classification
        $countsByBMI = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
        ->select('bmi_classification', DB::raw('count(*) as count'))
        ->where('child_health_records.health_worker_id', $healthWorkerId)
            ->groupBy('bmi_classification')
            ->get();

        // Fetch the count of children for each gender
        $countsBySex = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
        ->select('sex', DB::raw('count(*) as count'))
        ->where('child_health_records.health_worker_id', $healthWorkerId)
            ->groupBy('sex')
            ->get();

        // Calculate percentage for each gender
        $totalRecords = $countsBySex->sum('count');
        $countsBySex->each(function ($item) use ($totalRecords) {
            $item->percentage = ($item->count / $totalRecords) * 100;
        });

        // Fetch BMI chart data
        $currentYear = date('Y');
        $lastFourYears = range($currentYear - 3, $currentYear);

        $bmiCategories = ['Underweight', 'Normal Weight', 'Overweight', 'Obese'];

        $bmiChartData = [];

        foreach ($bmiCategories as $category) {
            $counts = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
                ->select(DB::raw('YEAR(child_health_records.created_at) as year'), DB::raw('count(*) as count'))
                ->where('bmi_classification', $category)
                ->where('child_health_records.health_worker_id', $healthWorkerId)
                ->whereIn(DB::raw('YEAR(child_health_records.created_at)'), $lastFourYears)
                ->groupBy(DB::raw('YEAR(child_health_records.created_at)'))
                ->pluck('count', 'year');
        
            $bmiChartData[] = [
                'label' => $category,
                'backgroundColor' => $this->generateRandomColor(),
                'data' => array_map('intval', $counts->toArray()),
            ];
        }
        
        return view('bhw-user.bhwDash', compact('countsByAge', 'countsByBMI', 'countsBySex', 'bmiChartData'));
    }
    private function generateRandomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
    }

