<?php


namespace App\Http\Controllers;

use App\Models\HealthWorker;
use Illuminate\Support\Facades\Log;


class SuperAdminController extends Controller
{
    public function superAdminAccountList()
    {
        try {
            $adminAccounts = HealthWorker::where('role', 'admin')->get();
            Log::info('Admin Accounts Retrieved: ' . $adminAccounts->toJson());
            
            return view('super-admin.superAdminAccount', compact('adminAccounts'));
        } catch (\Exception $e) {
            Log::error('Error in BHWChildController@index', ['error' => $e->getMessage()]);
            abort(500, 'Internal Server Error');
        }
    }
    


    }

