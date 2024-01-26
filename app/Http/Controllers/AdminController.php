<?php


namespace App\Http\Controllers;

use App\Models\HealthWorker;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{

    public function inputTable()
    {
        try {

            $adminAccounts = HealthWorker::where('role', 'admin')->get();


            return view('super-admin.superAdminAccount', compact('adminAccounts'));
        } catch (\Exception $e) {
            Log::error('Error in BHWChildController@index', ['error' => $e->getMessage()]);
            // You can handle the error in a way that makes sense for your application
            abort(500, 'Internal Server Error');
        }
    }


    }

