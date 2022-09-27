<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Chat\MessageController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Auth
Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post("login", LoginController::class);
    Route::post("logout", LogoutController::class);
});

// Messages
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('messages', MessageController::class)->only(['store', 'index']);
});

// Users
Route::group(['middleware' => 'auth:api', 'prefix' => 'users'], function () {
    // customer
    Route::get('/customers', [UserController::class, 'getCustomers']);
    Route::delete('/customers/{id}', [UserController::class, 'delete']);
});

// Reports
Route::group(['middleware' => 'auth:api', 'prefix' => 'reports'], function () {
    Route::get('/', [ReportController::class, 'getMyReport']);
    Route::post('/', [ReportController::class, 'doReport']);
});
