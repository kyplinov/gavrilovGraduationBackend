<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationUnitController;
use App\Http\Controllers\ConfigurationUnitTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'middleware' => 'api'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group(['prefix' => 'test', 'middleware' => 'jwt.auth'], function () {
    Route::get('', function (Request $request) {
        return "Hello, world!";
    });
});

Route::group(['prefix' => 'area', 'middleware' => 'jwt.auth'], function () {
    Route::get('registry', [AreaController::class, 'registry']);
    Route::post('', [AreaController::class, 'create']);
    Route::group(['prefix' => '{configurationUnitType}'], function () {
        Route::get('', [AreaController::class, 'get']);
        Route::put('', [AreaController::class, 'update']);
        Route::delete('', [AreaController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'statuses', 'middleware' => 'jwt.auth'], function () {
    Route::get('registry', [StatusController::class, 'registry']);
    Route::post('', [StatusController::class, 'create']);
    Route::group(['prefix' => '{statuses}'], function () {
        Route::get('', [StatusController::class, 'get']);
        Route::put('', [StatusController::class, 'update']);
        Route::delete('', [StatusController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'configurationUnitType', 'middleware' => 'jwt.auth'], function () {
    Route::get('registry', [ConfigurationUnitTypeController::class, 'registry']);
    Route::post('', [ConfigurationUnitTypeController::class, 'create']);
    Route::group(['prefix' => '{configurationUnitType}'], function () {
        Route::get('', [ConfigurationUnitTypeController::class, 'get']);
        Route::put('', [ConfigurationUnitTypeController::class, 'update']);
        Route::delete('', [ConfigurationUnitTypeController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'configurationUnit', 'middleware' => 'jwt.auth'], function () {
    Route::get('registry', [ConfigurationUnitController::class, 'registry']);
    Route::post('', [ConfigurationUnitController::class, 'create']);
    Route::group(['prefix' => '{configurationUnit}'], function () {
        Route::get('', [ConfigurationUnitController::class, 'get']);
        Route::put('', [ConfigurationUnitController::class, 'update']);
        Route::delete('', [ConfigurationUnitController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'department', 'middleware' => 'jwt.auth'], function () {
    Route::get('registry', [DepartmentController::class, 'registry']);
    Route::post('', [DepartmentController::class, 'create']);
    Route::group(['prefix' => '{department}'], function () {
        Route::get('', [DepartmentController::class, 'get']);
        Route::put('', [DepartmentController::class, 'update']);
        Route::delete('', [DepartmentController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'employee', 'middleware' => 'jwt.auth'], function () {
    Route::get('registry', [EmployeesController::class, 'registry']);
    Route::post('', [EmployeesController::class, 'create']);
    Route::group(['prefix' => '{employee}'], function() {
        Route::get('', [EmployeesController::class, 'get']);
        Route::put('', [EmployeesController::class, 'update']);
        Route::delete('', [EmployeesController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'file', 'middleware' => 'jwt.auth'], function () {
    Route::post('', [FileController::class, 'create']);
    Route::group(['prefix' => 'photo'], function() {
        Route::group(['prefix' => '{photo}'], function() {
            Route::get('', [PhotoController::class, 'get']);
        });
        Route::post('', [PhotoController::class, 'create']);
    });
});

Route::group(['prefix' => 'application', 'middleware' => 'jwt.auth'], function () {
    Route::get('registry', [ApplicationController::class, 'registry']);
    Route::post('', [ApplicationController::class, 'create']);
    Route::group(['prefix' => '{application}'], function() {
        Route::get('', [ApplicationController::class, 'get']);
        Route::put('', [ApplicationController::class, 'update']);
        Route::delete('', [ApplicationController::class, 'destroy']);
    });
});
