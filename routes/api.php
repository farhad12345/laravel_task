<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//companies Apis
Route::post('/add/company', [CompanyController::class,'SaveCompany']);
Route::get('/get/companies/list', [CompanyController::class,'GetCompaniesList']);
Route::get('/company/delete/{id}', [CompanyController::class,'DeleteCompany']);
Route::post('/company/update', [CompanyController::class,'UpdateCompany']);


Route::get('/get/companies/data', [CompanyController::class,'GetCompaniesData']);
//orders apis
Route::get('/get/orders/list', [OrderController::class,'GetOrdersList']);
Route::post('/add/orders', [OrderController::class,'saveOrder']);
Route::get('/order/delete/{id}', [OrderController::class,'DeleteOrder']);
Route::post('/order/update', [OrderController::class,'UpdateOrder']);
Route::get('/get/orders/data', [OrderController::class,'GetOrderData']);
