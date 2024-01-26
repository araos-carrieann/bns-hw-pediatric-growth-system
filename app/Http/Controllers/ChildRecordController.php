<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Municipality;
use Illuminate\Support\Facades\Log;


class ChildRecordController extends Controller
{
    
    public function storeNewHealthRecord(Request $request)
    {
        $healthWorkerId = session('userId'); // Retrieve health worker ID from the session
    
        try {
            // Create a child record associated with the health worker
            $healthWorker = \App\Models\HealthWorker::find($healthWorkerId);
    
            // Retrieve child_id from the form data
            $childId = $request->input('child_id');
            \Log::info($childId);
            // Create ChildHealthRecord record
            $childHealthRecordData = $request->except(['_token', 'child_id']); // Exclude unnecessary fields
            $childHealthRecordData['child_id'] = $childId;
    
            // Create ChildHealthRecord without 'health_worker_id'
            $childHealthRecord = $healthWorker->childHealthRecords()->create($childHealthRecordData);
    
            \Log::info('Created a new child record and health record');
            return redirect()->route('bhw-child.bhwInputTable');
        } catch (\Exception $e) {
            // Log the error and redirect with an error message
            \Log::error('Failed to create a new child record and health record: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to insert data: ' . $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $healthWorkerId = session('userId'); // Retrieve health worker ID from the session

        $data = $request->all();
        $municipality = Municipality::where('id', $data['municipality'])->value('name');
        $data['municipality'] = $municipality;
        $data['health_worker_id'] = $healthWorkerId; // Add health worker ID to the data

        try {
            // Create a child record associated with the health worker
            $healthWorker = \App\Models\HealthWorker::find($healthWorkerId);

            $childPersonalInformation = $healthWorker->childPersonalInformation()->create($data);

            if ($childPersonalInformation) {
                // Create ChildHealthRecord record
                $childHealthRecordData = $request->except(['health_worker_id']); // Exclude unnecessary fields
                $childHealthRecordData['child_id'] = $childPersonalInformation->id;

                // Create ChildHealthRecord without 'health_worker_id'
                $childHealthRecord = $healthWorker->childHealthRecords()->create($childHealthRecordData);

                // Rest of your code

                // Log success or redirect to success page
                Log::info('Created a new child record and health record');
                return redirect('/bhwInputTable')->withwith('success', 'Data inserted successfully!');
            } else {
                // Handle the case where ChildPersonalInformation creation failed
                return redirect()->back()->with('error', 'Failed to create ChildPersonalInformation');
            }
        } catch (\Exception $e) {
            // Log the error and redirect with an error message
            Log::error('Failed to create a new child record and health record: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to insert data: ' . $e->getMessage());
        }
    }

}