<?php

use App\Modules\Dashboard\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(array('Module'=>'Dashboard', 'middleware' => ['web','auth','GlobalSecurity']), function () {

    Route::get('/notifications/count', [DashboardController::class, 'notificationCount']);
    Route::get('/notifications/show', [DashboardController::class, 'notifications']);
    Route::get('/single-notification/{id}', [DashboardController::class, 'notificationSingle']);
    Route::get('/notification-all', [DashboardController::class, 'notificationAll']);
    Route::resource('dashboard', DashboardController::class);
    Route::get('server-info', [DashboardController::class, 'serverInfo']);
});
