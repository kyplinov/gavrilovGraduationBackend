<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DepartmentController;
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

Route::get('/test', function (Request $request) {
    return "Hello, world!";
});

Route::group(['prefix' => 'areas'], function () {
    Route::get('registry', [AreaController::class, 'registry']);
});

Route::group(['prefix' => 'departments'], function () {
    Route::get('registry', [DepartmentController::class, 'registry']);
});
