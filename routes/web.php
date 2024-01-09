<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthWorkerController;
use App\Http\Controllers\ChildRecordController;
use App\Http\Controllers\DropdownController;

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
    return view('super-admin/superAdminDash');
});*/
Route::get('/', function () {
    return view('/bhw-user/bhwInputData');
});
/*Route::get('/', function () {
    return view('index');
});*/

Route::post('/login', [HealthWorkerController::class, 'login'])->name('HealthWorker.login');


Route::get('/bhwInputData', [DropdownController::class, 'index']);
Route::get('/getBrgy/{municipalityId}', [DropdownController::class, 'getBrgy']);

Route::resource('/ChildRecord', ChildRecordController::class);
Route::resource('/HealthWorker', HealthWorkerController::class);


Route::get('/admin-accounts', [HealthWorkerController::class, 'showAdminAccounts'])->name('admin.accounts');
Route::get('/admin/edit/{id}', [HealthWorkerController::class, 'editAdminAccount'])->name('admin.edit');
Route::delete('/admin/delete/{id}', [HealthWorkerController::class, 'deleteAdminAccount'])->name('admin.delete');

Route::get('/superAdminDash', function () {
    return view('super-admin.superAdminDash');
});

Route::get('/superAdminAccount', function () {
    return view('super-admin.superAdminAccount');
});

Route::get('/superAdminRecord', function () {
    return view('super-admin.superAdminRecord');
});


