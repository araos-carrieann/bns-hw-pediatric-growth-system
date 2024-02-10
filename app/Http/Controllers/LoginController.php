<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\HealthWorker;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    function authlogin(){
        return view('index');
    }


    public function checkLogin(Request $request)
    { 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12'
        ]);
       
        $credentials = $request->only('email', 'password');
    
        Log::info('Received login attempt with email: ' . $credentials['email']);
    
        $worker = HealthWorker::where('email', $credentials['email'])->first();
    
        if ($worker && $worker->status === 'active' && Hash::check($credentials['password'], $worker->password)) {
            // Set session data
            $request->session()->put('LoggedUser', $worker->id);
            $request->session()->put('UserRole', $worker->role);
            $request->session()->put('UserBrgy', $worker->barangay);
            $request->session()->put('UserLastName', $worker->last_name);
            $request->session()->put('UserPic', $worker->profile_picture);
            
            // Redirect based on user role
            if ($worker->role === 'admin') {
                return redirect('/adminDash');
            } elseif ($worker->role === 'superAdmin') {
                return redirect('/superAdminDash');
            } elseif ($worker->role === 'bhw-user') {
                return redirect('/bhwDash');
            } 
        } else {
            Log::error('Login attempt failed for email: ' . $credentials['email']);
            return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
        }
    }

    
    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect()->route('authlogin');
        }
    }

}
