<?php

use App\Http\Controllers\BHWChildController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthWorkerController;
use App\Http\Controllers\ChildRecordController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::post('/checkLogin', [LoginController::class, 'checkLogin'])->name('check.login');

Route::get('/authlogout', [LoginController::class, 'logout'])->name('authlogout');


Route::middleware(['AuthCheck'])->group(function () {
    // Protected routes for authenticated users
    Route::get('/authlogin', [LoginController::class, 'authlogin'])->name('authlogin');

    /*FOR ADMIN PAGES*/
    Route::group(['middleware' => 'checkrole:admin'], function () {
        // Routes accessible only to users with the 'superAdmin' role
        Route::get('/adminDash', [AdminController::class, 'charts']);
        Route::get('/adminRecordTable', [AdminController::class, 'tableRecord'])->name('admin.tableRecord');
        Route::get('/adminAccount', [AdminController::class, 'adminAccountList']);

        Route::get('/admin/filter', [AdminController::class, 'filter'])->name('admin.filter');
        Route::get('/admin/reset', [AdminController::class, 'reset'])->name('admin.reset');
        Route::get('/admin/export-pdf', [AdminController::class, 'exportPDF'])->name('admin.exportPDF');
        Route::get('/admin/export-excel', [AdminController::class, 'exportExcel'])->name('admin.exportExcel');
    });


    /*FOR SUPER ADMIN PAGES*/
    Route::group(['middleware' => 'checkrole:superAdmin'], function () {
        // Routes accessible only to users with the 'admin' role
        Route::get('/superAdminDash', [SuperAdminController::class, 'charts']);
        Route::get('/superAdminAccount', [SuperAdminController::class, 'superAdminAccountList']);
        Route::get('/superAdminRecordTable', [SuperAdminController::class, 'tableRecord'])->name('super-admin.tableRecord');

        Route::get('/superAdmin/filter', [SuperAdminController::class, 'filter'])->name('superAdmin.filter');
        Route::get('/superAdmin/reset', [SuperAdminController::class, 'reset'])->name('superAdmin.reset');
        Route::get('/superAdmin/export-pdf', [SuperAdminController::class, 'exportPDF'])->name('superAdmin.exportPDF');
        Route::get('/superAdmin/export-excel', [SuperAdminController::class, 'exportExcel'])->name('superAdmin.exportExcel');
    });


    /*FOR BHW PAGES*/
    Route::group(['middleware' => 'checkrole:bhw-user'], function () {
        Route::get('/bhwDash', [BHWChildController::class, 'charts']);
        Route::get('/insertNewChildRecord', function () {
            return view('bhw-user.bhwInputData');
        });
        Route::get('/bhwInputTable', [BHWChildController::class, 'inputTable']);
        Route::get('/bhwRecordTable', [BHWChildController::class, 'tableRecord'])->name('bhw-child.tableRecord');

        Route::get('/bhw-child/filter', [BHWChildController::class, 'filter'])->name('bhw-child.filter');
        Route::get('/bhw-child/reset', [BHWChildController::class, 'reset'])->name('bhw-child.reset');
        Route::get('/bhw-child/export-pdf', [BHWChildController::class, 'exportPDF'])->name('bhw-child.exportPDF');
        Route::get('/bhw-child/export-excel', [BHWChildController::class, 'exportExcel'])->name('bhw-child.exportExcel');
    });
});

// Other routes outside the middleware group





/* FOR ALL */
Route::get('/bhwInputData', [DropdownController::class, 'index']);
Route::get('/getBrgy/{municipalityId}', [DropdownController::class, 'getBrgy']);
Route::get('/search', [SearchController::class, 'search']);
Route::get('/searchBHW', [SearchController::class, 'searchBhwAccount']);
Route::get('/searchAdmin', [SearchController::class, 'searchAdminAccount']);


/*FOR ALL HEALTH WORKER*/


Route::post('/admin/delete/{id}', [HealthWorkerController::class, 'deleteAccount'])->name('admin.delete');
Route::post('/admin/update/{id}', [HealthWorkerController::class, 'update'])->name('admin.update');
Route::post('/bhw-user/update/{id}', [HealthWorkerController::class, 'update'])->name('bhw-user.update');
Route::post('/bhw-user/delete/{id}', [HealthWorkerController::class, 'deleteAccount'])->name('bhw-user.delete');
Route::resource('/ChildRecord', ChildRecordController::class);
Route::resource('/HealthWorker', HealthWorkerController::class);
// Add the custom route for storing health records
Route::post('/child-record/store-new-health-record', [ChildRecordController::class, 'storeNewHealthRecord'])
    ->name('ChildRecord.storeNewHealthRecord');
