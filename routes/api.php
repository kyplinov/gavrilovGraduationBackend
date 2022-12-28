<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\ConfigurationUnitTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PhotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return "Hello, world!";
});

Route::group(['prefix' => 'area'], function () {
    Route::get('registry', [AreaController::class, 'registry']);
    Route::post('', [AreaController::class, 'create']);
    Route::group(['prefix' => '{configurationUnitType}'], function () {
        Route::get('', [AreaController::class, 'get']);
        Route::put('', [AreaController::class, 'update']);
        Route::delete('', [AreaController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'configurationUnitType'], function () {
    Route::get('registry', [ConfigurationUnitTypeController::class, 'registry']);
    Route::post('', [ConfigurationUnitTypeController::class, 'create']);
    Route::group(['prefix' => '{configurationUnitType}'], function () {
        Route::get('', [ConfigurationUnitTypeController::class, 'get']);
        Route::put('', [ConfigurationUnitTypeController::class, 'update']);
        Route::delete('', [ConfigurationUnitTypeController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'department'], function () {
    Route::get('registry', [DepartmentController::class, 'registry']);
    Route::post('', [DepartmentController::class, 'create']);
    Route::group(['prefix' => '{department}'], function () {
        Route::get('', [DepartmentController::class, 'get']);
        Route::put('', [DepartmentController::class, 'update']);
        Route::delete('', [DepartmentController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'employee'], function () {
    Route::get('registry', [EmployeesController::class, 'registry']);
    Route::post('', [EmployeesController::class, 'create']);
    Route::group(['prefix' => '{employee}'], function() {
        Route::get('', [EmployeesController::class, 'get']);
    });
});

Route::group(['prefix' => 'file'], function () {
    Route::post('', [FileController::class, 'create']);
    Route::group(['prefix' => 'photo'], function() {
        Route::group(['prefix' => '{photo}'], function() {
            Route::get('', [PhotoController::class, 'get']);
        });
        Route::post('', [PhotoController::class, 'create']);
    });
});
