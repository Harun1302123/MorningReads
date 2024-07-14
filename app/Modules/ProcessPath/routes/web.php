<?php

use App\Modules\ProcessPath\Http\Controllers\ClientProcessPathController;
use App\Modules\ProcessPath\Http\Controllers\ProcessListController;
use App\Modules\ProcessPath\Http\Controllers\ProcessPathController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'ProcessPath', 'middleware' => ['web', 'auth', 'XssProtection', 'GlobalSecurity']), function () {
    //List of all process
    Route::get('process/list', [ProcessPathController::class, 'processListById']);
    Route::post('process/list', [ProcessPathController::class, 'processListById']);
    Route::get('process/list/{process_id}', [ProcessPathController::class, 'processListById']);
    //Process details
    Route::post('process-path/get-desk-by-status', [ProcessPathController::class, 'getDeskByStatus']);
    Route::post('process-path/batch-process-update', [ProcessPathController::class, 'updateProcess']);
    Route::get('process-path/check-process-validity', [ProcessPathController::class, 'checkApplicationValidity']);
    Route::get('process-path/ajax/{param}', [ProcessPathController::class, 'ajaxRequest']);
    Route::get('process/get-list/{status?}/{desk?}', [
        'as' => 'process.getList',
        'uses' => 'ProcessPathController@getList'
    ]);
    Route::get('process/set-process-type', [
        'as' => 'process.setProcessType',
        'uses' => 'ProcessPathController@setProcessType'
    ]);
    Route::get('process/search-process-type', [
        'as' => 'process.searchProcessType',
        'uses' => 'ProcessPathController@searchProcessType'
    ]);
    // New Process route
    Route::get('process/{module}/add/{process_type_id}', [ProcessPathController::class, 'applicationAdd']);
    Route::get('process/{module}/view/{app_id}/{process_type_id}', [ProcessPathController::class, 'applicationOpen']);
    Route::get('process/{module}/edit/{app_id}/{process_type_id}', [ProcessPathController::class, 'applicationEdit']);
    //Route::resource('ProcessPath', 'ProcessPathController');
    Route::post('process/help-text', [ProcessPathController::class, 'getHelpText']);
    Route::get('process/favorite-data-store', [ProcessPathController::class, 'favoriteDataStore']);
    Route::get('process/favorite-data-remove', [ProcessPathController::class, 'favoriteDataRemove']);
    Route::get('process-path/request-shadow-file', [ProcessPathController::class, 'requestShadowFile']);
    // Process flow graph route
    Route::get('process/graph/{process_type_id}/{app_id}/{cat_id}', [ProcessPathController::class, 'getProcessData']);
    // get shadow file history
    Route::get('process/get-shadow-file-hist/{process_type_id}/{ref_id}', [ProcessPathController::class, 'getShadowFileHistory']);
    // get application history
    Route::get('process/get-app-hist/{process_list_id}', [ProcessPathController::class, 'getApplicationHistory']);
    //get desk by user
    Route::post('process-path/get-user-by-desk', [ProcessPathController::class, 'getUserByDesk']);
    //batch process
    Route::get('process/batch-process-set', [ProcessPathController::class, 'batchProcessSet']);
    Route::get('process/batch-process-skip/{id}', [ProcessPathController::class, 'skipApplication']);
    Route::get('process/batch-process-previous/{id}', [ProcessPathController::class, 'previousApplication']);
    Route::get('process-path/verify_history/{process_list_id}', [ProcessPathController::class, 'verifyProcessHistory']);
    // Certificate Regeneration
    Route::get('process/certificate-regeneration/{app_id}/{process_type_id}', [ProcessPathController::class, 'certificateRegeneration']);
    // Service wise application count and list
    Route::post('process/get-servicewise-count', [ProcessPathController::class, 'statusWiseApps']);
});


/** the code only for client */
Route::group(['module' => 'ProcessPath', 'prefix' => 'client', 'middleware' => ['web', 'auth', 'GlobalSecurity']], function () {
    Route::get('process/list', [ClientProcessPathController::class, 'processListById']);
    Route::get('process/details/{id}', [ClientProcessPathController::class, 'processDetails']);
    Route::get('process/check-cancellation', [ClientProcessPathController::class, 'checkCancellation']);
    Route::get('process/set-can-app', [ClientProcessPathController::class, 'setCanApp']);
    // New Process route
    Route::get('process/{module}/add/{process_type_id}', [ProcessPathController::class, 'applicationAdd']);
    Route::get('process/{module}/view/{app_id}/{process_type_id}', [ProcessPathController::class, 'applicationOpen']);
    Route::get('process/{module}/edit/{app_id}/{process_type_id}', [ProcessPathController::class, 'applicationEdit']);
    
});


Route::group(['module' => 'ProcessPath', 'prefix' => 'vue', 'middleware' => ['web', 'auth', 'GlobalSecurity']], function () {
    Route::get('get-auth-data', [ProcessListController::class, 'getAuthData']);
    Route::get('process', [ProcessListController::class, 'index']);
    Route::get('process/get-list/{status?}/{desk?}', [ProcessListController::class, 'getList']);
    Route::get('process-type', [ProcessListController::class, 'getProcessTypes']);
    Route::get('process-type/{process_type_id}', [ProcessListController::class, 'getProcessTypeInfo']);
    Route::post('process/favorite-data-store', [ProcessPathController::class, 'favoriteDataStore']);
    Route::post('process/favorite-data-remove', [ProcessPathController::class, 'favoriteDataRemove']);
    Route::get('process-type/{process_type_id}/status', [ProcessListController::class, 'getStatusListByProcessType']);
    Route::get('process/view/{app_id}/{process_type_id}', [ProcessListController::class, 'applicationView']);
    Route::post('process/update', [ProcessListController::class, 'updateProcessVue']);
    Route::get('process/shadow-file-hist/{process_type_id}/{ref_id}', [ProcessListController::class, 'getShadowFileHistory']);
    Route::get('process/history/{process_list_id}', [ProcessListController::class, 'getApplicationHistory']);
    Route::get('process/status-wise-app-count/{process_type_id}', [ProcessListController::class, 'statusWiseAppsCount']);
});