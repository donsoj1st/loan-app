<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankControllers;
use App\Http\Controllers\BankEmployeeControllers;
use App\Http\Controllers\ClientControllers;
use App\Http\Controllers\MerchantControllers;
use App\Http\Controllers\MerchantEmployeeControllers;
use App\Http\Controllers\AuthController;

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
//public route

// creating bank employees
Route::post('/banks/register/employee', [AuthController::class, 'registerBankEmployee']);
Route::post('/banks/employee/login', [AuthController::class, 'bankLogin']);
Route::post('/banks/employee/forgotpassword', [AuthController::class, 'bankForgotPassword']);
Route::post('/banks/employee/passwordreset/{id}', [AuthController::class, 'bankResetPassword']);
Route::post('/banks/employee/resendotp', [AuthController::class, 'resendOtp']);
Route::patch('/banks/employee/verify/{id}', [AuthController::class, 'BankVerify']);


// creating merchant employees
Route::post('/merchants/register/employee', [AuthController::class, 'registerMerchantEmployee']);
Route::post('/merchants/employee/login', [AuthController::class, 'merchantLogin']);
Route::post('/merchants/employee/forgotpassword', [AuthController::class, 'merchantForgotPassword']);
Route::post('/merchants/employee/passwordreset/{id}', [AuthController::class, 'merchantResetPassword']);
Route::post('/merchants/employee/resendotp', [AuthController::class, 'resendMerchantOtp']);
Route::patch('/merchants/employee/verify/{id}', [AuthController::class, 'merchantVerify']);

Route::resource('banks', BankControllers::class);
Route::resource('Bank_employee', BankEmployeeControllers::class);
Route::resource('client', ClientControllers::class);
Route::resource('merchants', MerchantControllers::class);
Route::resource('merchant_employee', MerchantEmployeeControllers::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->delete('/logout', [AuthController::class, 'logout']);
