<?php

use App\Modules\ReportsV2\Http\Controllers\ReportsControllerV2;
use Illuminate\Support\Facades\Route;


Route::group(['module' => 'ReportsV2', 'middleware' => ['web', 'auth', 'XssProtection', 'GlobalSecurity']], function () {

    Route::get('/reportv2', [ReportsControllerV2::class, 'index']);
    Route::get('/reportv2/create', [ReportsControllerV2::class, 'create']);
    Route::get('/reportv2/edit/{id}', [ReportsControllerV2::class, 'edit']);
    Route::get('/reportv2/view/{id}', [ReportsControllerV2::class, 'view']);
    Route::get('/reportv2/getuserbytype', [ReportsControllerV2::class, 'getusers']);
    Route::get('/reportv2/add-to-favourite/{id}', [ReportsControllerV2::class, 'addToFavourite']);
    Route::get('/reportv2/remove-from-favourite/{id}', [ReportsControllerV2::class, 'removeFavourite']);
    Route::post('/reportv2/add-remove-favourite-ajax', [ReportsControllerV2::class, 'addRemoveFavouriteAjax']);
    Route::post('/reportv2/verify', [ReportsControllerV2::class, 'reportsVerify']);
    Route::get('/reportv2/tables', [ReportsControllerV2::class, 'showTables']);
    Route::get('/reportv2/get-report-category', [ReportsControllerV2::class, 'getReportCategory']);
    Route::post('/reportv2/show-report/{report_id}', [ReportsControllerV2::class, 'showReport']);
    Route::get('/reportv2/show-report/{report_id}', [ReportsControllerV2::class, 'showReport']);

    //ob#code@start - Harun - need to check this 
    foreach (glob(__DIR__ . '/routes/*.php') as $route_file) {
        require $route_file;
    }

    Route::patch('/reportv2/store', [ReportsControllerV2::class, 'store']);
    Route::patch('/reportv2/update/{id}', [ReportsControllerV2::class, 'update']);
});
