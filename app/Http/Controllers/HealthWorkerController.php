<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\HealthWorker;


class HealthWorkerController extends Controller
{
    protected $worker;

    public function __construct()
    {
        $this->worker = new HealthWorker();
    }

    public function store(Request $request)
    {
        // $healthWorkerId = session('userId'); // Retrieve health worker ID from the session

        $data = $request->except('_token'); // Exclude _token from data
        $pictureName = time() . $request->file('profile_picture')->getClientOriginalName();
        $path = $request->file('profile_picture')->storeAs('public/bhwProfile', $pictureName, 'local');
        $data["profile_picture"] = '/storage/bhwProfile/' . $pictureName;
        
    
        $municipality = Municipality::where('id', $data['municipality'])->value('name');
        $data['municipality'] = $municipality; // Replace municipality ID with its name

        try {
            // Hash the password before storing it
            $data['password'] = Hash::make($data['password']);

            HealthWorker::create($data);

            Log::info('Created a health worker');

            return redirect()->back()->with('success', 'Data inserted successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create a new health worker: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to insert data: ' . $e->getMessage());
        }
    }


    public function deleteAccount($id)
    {
        $worker = $this->worker->find($id);

        if ($worker) {
            $worker->status = 'deactivated'; // Set the status to 'deactivated'

            $worker->save();
        }

        return redirect()->back()->with('success', 'Data deleted successfully!');
    }
   
    public function update(Request $request, $id)
    {
        // Find the health worker by ID
        $worker = HealthWorker::findOrFail($id);

        // Remove the _token field from the request data
        $data = $request->except('_token');

        // Update the health worker attributes with the remaining request data
        $worker->update($data);

        // Log the update
        Log::info('Updated health worker record with ID: ' . $id);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Data updated successfully!');
    }
}