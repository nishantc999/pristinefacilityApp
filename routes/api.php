<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\API\{
    ClientForgotPasswordController,
    ClientAuthController,
    ClientResetPasswordController
};
use App\Http\Controllers\API\Clients\{
    EmployeeController,
    DataController,
    FeedbackController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/client/login', [ClientAuthController::class, 'login']);

Route::prefix('client')->middleware('auth:clientapi')->group(function () {
    Route::post('logout', [ClientAuthController::class, 'logout']);
    Route::post('register/employee', [EmployeeController::class, 'registerEmployee']);
    Route::post('/check-username', [EmployeeController::class, 'checkUsernameAvailability']);

    Route::get('/sites', [DataController::class, 'getAllSites']);
    Route::get('/sites-with-relations', [DataController::class, 'getAllSiteswithRelations']); //

    Route::get('checklist/{id}', [FeedbackController::class, 'getChecklist']);
    Route::post('checklist/feedback', [FeedbackController::class, 'storeFeedback']);



    Route::post('password/email', [ClientForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ClientResetPasswordController::class, 'reset']);
});



