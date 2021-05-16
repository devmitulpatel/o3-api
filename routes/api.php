<?php

use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\DebugController;
use App\Http\Controllers\API\LoginController;

use App\Http\Controllers\API\RegisterUserController;
use App\Http\Controllers\API\UserController;
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

Route::prefix('api/v1')->group(function (){



    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('user', 'UserController')->only('update');
        Route::get('user/extra/options',[UserController::class,'options']);
        Route::resource('devices', 'DeviceController')->only('store');
        Route::get('auth/check',[UserController::class,'check']);
        Route::resource('company','CompanyController');
        Route::get('company/extra/options',[CompanyController::class,'options']);

    });

    Route::prefix('auth')->middleware('guest:sanctum')->group(function() {
        Route::post('login', [LoginController::class,'login']);
        Route::resource('register/{type}','RegisterUserController')->only('store');
        Route::get('register-data',[RegisterUserController::class,'registerData']);
    });

    Route::prefix('debug')->group(function () {
        Route::get('all-user',[DebugController::class,'allUser']);
        Route::get('all-companies',[DebugController::class,'allCompanies']);
        Route::get('user/{user}',[DebugController::class,'getUser']);
        Route::get('user/as/{user}',[DebugController::class,'loginAsUser']);
        });


});
