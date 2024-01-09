<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

    public function index()
    {
        $workers = HealthWorker::all();

        Log::info('Retrieved all health workers');

        return view('workers.index', ['workers' => $workers]);
    }

    public function create()
    {
        Log::info('Viewed create form for health worker');

        return view('workers.create');
    }

    public function store(Request $request)
    {
        // $healthWorkerId = session('userId'); // Retrieve health worker ID from the session

        $data = $request->all();
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

        if ($worker && Hash::check($credentials['password'], $worker->password)) {
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



    public function showAdminAccounts()
    {
        $adminAccounts = HealthWorker::where('role', 'admin')
            ->select('role', 'id', 'profile_picture', 'last_name', 'first_name', 'middle_name', 'municipality', 'barangay', 'sitio', 'email', 'contact_number')
            ->get();

        return view('/superAdminAccount', ['adminAccounts' => $adminAccounts]);
    }





    public function edit($id)
    {
        $response['worker'] = $this->worker->find($id);
        return view('workers.edit')->with($response);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // Add validation rules if needed for updating worker information
        ]);

        $worker = $this->worker->find($id);

        $workerData = $request->only([
            'role',
            'worker_id',
            'profile_picture',
            'last_name',
            'first_name',
            'middle_name',
            'email',
            'contact_number',
            'password',
        ]);

        $workerData['password'] = bcrypt($workerData['password']); // Hashing the password

        $worker->update($workerData);
        return redirect('worker');
    }

    public function destroy($id)
    {
        $worker = $this->worker->find($id);
        $worker->delete();
        return redirect('worker');
    }
}









