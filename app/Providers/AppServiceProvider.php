<?php

namespace App\Providers;
use App\Models\ChildHealthRecord;
use App\Models\ChildPersonalInformation;
use App\Models\HealthWorker;
use Illuminate\Support\Facades\View;
use App\Models\Municipality;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


     public function boot()
     {
         $muni = Municipality::get(['name', 'id']);
         View::share('muni', $muni);

         $barangay = Municipality::get(['name', 'id']);
         View::share('barangay', $barangay);
 

     }

}

