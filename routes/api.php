<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    ClientForgotPasswordController,
    ClientAuthController,
    ClientResetPasswordController
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

// Route::post('/login', [LoginController::class,'login']);
// Route::group(['middleware' =>['api','auth:apigaurd']], function () {
    
    

// });
// client routes 
Route::prefix('client')->group(function () {
    Route::post('login', [ClientAuthController::class, 'login']);
    Route::post('register', [ClientAuthController::class, 'register']);
    Route::post('password/email', [ClientForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ClientResetPasswordController::class, 'reset']);
   
});

Route::group(['middleware' =>['api','auth:clientapi']], function () {
    Route::post('logout', [ClientAuthController::class, 'logout']);

    

});