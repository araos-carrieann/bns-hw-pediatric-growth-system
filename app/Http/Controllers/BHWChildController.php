<?php


namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\ChildPersonalInformation;
use Illuminate\Support\Facades\Log;
use App\Export\ExportChildRecord;
use Barryvdh\DomPDF\PDF;


class BHWChildController extends Controller
{

    public function inputTable()
    {
        try {
            $healthWorkerId = session('userId');

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
            $healthWorkerId = session('userId');

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
        $healthWorkerId = session('userId');

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
        $pdf->loadView('bhw-user.pdfLayout', compact('data'));
    
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
    

    }

