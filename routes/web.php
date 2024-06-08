<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RoleController,
    UserManagementController,
    SKUController,
    DashboardController,
    ReportsController,
    PrivacyPolicyController,
    ShiftController,
    ClientManagementController,
    EmployeeController


};
use App\Http\Controllers\Clients\ClientController;
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
    // return view('welcome');
    return redirect()->route('login');
});

Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {

    // profile route

    Route::get('/profile',[DashboardController::class,'profile'])->name('profile');
    Route::post('/profile',[DashboardController::class,'profilestore'])->name('profile.store');
     // set global city



    // role route
    Route::resource('role', RoleController::class);
    Route::get('/role-status',[RoleController::class,'status'])->name('role.status');
    Route::get('/get_role_name',[RoleController::class,'get_role_name'])->name('role.get_role_name');


// feild executive role
Route::get('/role-feildexecutive',[RoleController::class,'feildexecutiveIndex'])->name('role.feildexecutive.index');
Route::get('/role-feildexecutive-create',[RoleController::class,'feildexecutiveCreate'])->name('role.feildexecutive.create');
Route::get('/role-feildexecutive-edit/{id}',[RoleController::class,'feildexecutiveEdit'])->name('role.feildexecutive.edit');
Route::post('/role-feildexecutive-create',[RoleController::class,'feildexecutiveStore'])->name('role.feildexecutive.store');
Route::post('/role-feildexecutive-edit/{id}',[RoleController::class,'feildexecutiveUpdate'])->name('role.feildexecutive.update');


    // user management route
    Route::resource('usermanagement', UserManagementController::class);
    Route::get('/user-status',[UserManagementController::class,'status'])->name('user.status');
    Route::get('/get-users-by-role/{roleId}',[UserManagementController::class,'getUsersByRole'])->name('get.users.by.role');
    // sku management route

    Route::resource('sku', SKUController::class);
    Route::resource('shiftmanagement', ShiftController::class);
    // client route
    Route::resource('clientmanagement', ClientManagementController::class);
    Route::get('/client-step-2/{id}',[ClientManagementController::class,'showStep2'])->name('clientmanagement.create_step2');
    Route::post('/client-step-2',[ClientManagementController::class,'postStep2'])->name('clientmanagement.store_step2');
    Route::get('/client-step-2-edit/{id}',[ClientManagementController::class,'step_2_edit'])->name('clientmanagement.step_2_edit');
    Route::patch('/client-step-2-update/{id}',[ClientManagementController::class,'step_2_update'])->name('clientmanagement.step_2_update');

    Route::get('/get_district_on_state_id',[ClientManagementController::class,'get_district_on_state_id'])->name('get_district_on_state_id');
    Route::get('/get_city_on_district_id',[ClientManagementController::class,'get_city_on_district_id'])->name('get_city_on_district_id');
      // employee route
    Route::resource('employeemanagement', EmployeeController::class);
    Route::get('/clients/shifts/site',[EmployeeController::class,'getSiteByClientAndShift'])->name('clientmanagement.getSiteByClientAndShift');
    Route::get('/clients/shifts/site/area',[EmployeeController::class,'getAreaSiteWise'])->name('clientmanagement.getAreaSiteWise');
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



});

// public route





Route::get('/privacy-policy', [PrivacyPolicyController::class, 'privacy_policy'])->name('privacy_policy');

// Route::middleware(['auth', 'can:manage-clients'])->group(function () {
    Route::middleware(['auth'])->group(function () {
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
    Route::post('clients/check-username', [ClientController::class, 'checkUsername'])->name('clients.checkUsername');
    Route::get('/clients/profile/{id}', [ClientController::class, 'profile'])->name('client.profile');

    // Client Profile
    Route::get('clients/dashboard/{id}', [ClientController::class, 'dashboard'])->name('clients.dashboard');
    Route::get('clients/business-details/{id}', [ClientController::class, 'businessDetails'])->name('business-details');
    Route::get('clients/shifts/{id}', [ClientController::class, 'shifts'])->name('shifts');
    Route::post('/shifts/store/{id}', [ClientController::class, 'storeShift'])->name('shift.store');
    Route::get('clients/areas/{id}', [ClientController::class, 'areas'])->name('areas');
    Route::get('clients/lines-floors/{id}            ', [ClientController::class, 'linesFloors'])->name('lines-floors');
});


