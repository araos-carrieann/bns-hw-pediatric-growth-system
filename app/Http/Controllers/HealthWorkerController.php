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

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        \Log::info('Received login attempt with email: ' . $credentials['email']);

        $worker = HealthWorker::where('email', $credentials['email'])->first();

        if ($worker && $worker->status === 'active' && Hash::check($credentials['password'], $worker->password)) {
            // Set session data
            session(['userId' => $worker->id]);

            // Redirect based on user role
            if ($worker->role === 'admin') {
                return redirect()->intended('/adminDash');
            } elseif ($worker->role === 'superAdmin') {
                return redirect()->intended('/superAdminDash');
            } elseif ($worker->role === 'bhw-user') {
                return redirect()->intended('/bhwDash');
            } else {
                return redirect('/');
            }
        } else {
            \Log::error('Login attempt failed for email: ' . $credentials['email']);
            return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
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
        $worker = HealthWorker::findOrFail($id);

        $worker->update($request->all());

        Log::info('Updated worker record with ID: ' . $id);
        return redirect()->back()->with('success', ' successfully!');
    }
}
