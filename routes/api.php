<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankControllers;
use App\Http\Controllers\BankEmployeeControllers;
use App\Http\Controllers\ClientControllers;
use App\Http\Controllers\MerchantControllers;
use App\Http\Controllers\MerchantEmployeeControllers;

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

Route::resource('banks', BankControllers::class);
Route::resource('Bank_employee', BankEmployeeControllers::class);
Route::resource('client', ClientControllers::class);
Route::resource('merchants', MerchantControllers::class);
Route::resource('merchant_employee', MerchantEmployeeControllers::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
