<?php

use App\Http\Controllers\AreaController;
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
});

Route::group(['prefix' => 'department'], function () {
    Route::get('registry', [DepartmentController::class, 'registry']);
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
        Route::get('', [PhotoController::class, 'getPhoto']);
        Route::post('', [PhotoController::class, 'create']);
    });
});
