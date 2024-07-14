<?php

use App\Modules\IndustryNew\Http\Controllers\IndustryNewControllerVue;
use App\Modules\IndustryNew\Http\Controllers\IndustryNewController;
use App\Modules\ProcessPath\Http\Controllers\ProcessPathController;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'IndustryNew', 'middleware' => ['web', 'auth', 'checkAdmin']], function () {
    Route::get('industry-new/add', [IndustryNewController::class, 'appForm']);
    Route::get('industry-new/edit/{id}/{openMode}', [IndustryNewController::class, 'appFormEdit']);
    Route::post('industry-new/store', [IndustryNewController::class, 'appStore']);
    Route::get('industry-new/view/{id}/{openMode}', [IndustryNewController::class, 'appFormView']);
    Route::get('industry-new/preview', [IndustryNewController::class, 'preview']);
});

// Process path related route
Route::group(array('module' => 'IndustryNew', 'prefix' => 'client', 'middleware' => ['web', 'auth', 'checkAdmin', 'GlobalSecurity']), function () {

    Route::get('industry-new/list/{process_type_id}', [ProcessPathController::class, 'processListById']);
});

// Process path related route
Route::group(array('module' => 'IndustryNew', 'middleware' => ['web', 'auth', 'checkAdmin']), function () {

    Route::get('industry-new/list/{process_type_id}', [ProcessPathController::class, 'processListById']);
});

Route::group(['module' => 'IndustryNew', 'prefix' => 'vue', 'middleware' => ['web', 'auth', 'checkAdmin']], function () {
    Route::get('industry-new/view/{id}', [IndustryNewControllerVue::class, 'appFormView']);
});
