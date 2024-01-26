<?php
use App\Http\Controllers\BHWChildController;

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthWorkerController;
use App\Http\Controllers\ChildRecordController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\SuperAdminController;

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
/*Route::get('/', function () {
    return view('index');
});*/
Route::get('/', function () {
    return view('admin/adminAccount');
});

/*Route::get('/', function () {
    return view('/bhw-user/bhwInputData');
});*/

/* FOR ALL */
Route::get('/bhwInputData', [DropdownController::class, 'index']);
Route::get('/getBrgy/{municipalityId}', [DropdownController::class, 'getBrgy']);
Route::get('/search', [SearchController::class, 'search']);


/*FOR ALL HEALTH WORKER*/
Route::post('/login', [HealthWorkerController::class, 'login'])->name('HealthWorker.login');

Route::delete('/admin/delete/{id}', [HealthWorkerController::class, 'deleteAccount'])->name('admin.delete');
Route::delete('/admin/update/{id}', [HealthWorkerController::class, 'deleteAccount'])->name('admin.update');
Route::delete('/bhw-user/delete/{id}', [HealthWorkerController::class, 'deleteAccount'])->name('bhw-user.delete');
Route::resource('/ChildRecord', ChildRecordController::class);
Route::resource('/HealthWorker', HealthWorkerController::class);
// Add the custom route for storing health records
Route::post('/child-record/store-new-health-record', [ChildRecordController::class, 'storeNewHealthRecord'])
    ->name('ChildRecord.storeNewHealthRecord');
/*FOR SUPER ADMIN PAGES*/
Route::get('/superAdminDash', function () {
    return view('super-admin.superAdminDash');
});

Route::get('/superAdminAccount', [SuperAdminController::class, 'superAdminAccountList']);
/*FOR ADMIN PAGES*/
Route::get('/adminDash', function () {
    return view('admin.adminDash');
});
Route::get('/adminAccount', function () {
    return view('admin.adminAccount');
});




/*FOR BHW PAGES*/
Route::get('/bhwDash', function () {
    return view('bhw-user.bhwDash');
});

Route::get('/insertNewChildRecord', function () {
    return view('bhw-user.bhwInputData');
});
Route::get('/bhwInputTable', [BHWChildController::class, 'inputTable']);
Route::get('/bhwRecordTable', [BHWChildController::class, 'tableRecord'])->name('bhw-child.tableRecord');

Route::get('/bhw-child/filter', [BHWChildController::class, 'filter'])->name('bhw-child.filter');
Route::get('/bhw-child/reset', [BHWChildController::class, 'reset'])->name('bhw-child.reset');
Route::get('/bhw-child/export-pdf', [BHWChildController::class, 'exportPDF'])->name('bhw-child.exportPDF');
Route::get('/bhw-child/export-excel', [BHWChildController::class, 'exportExcel'])->name('bhw-child.exportExcel');





