<?php

use App\Modules\DynamicApiEngine\Http\Controllers\DynamicApiAuthenticationController;
use App\Modules\DynamicApiEngine\Http\Controllers\DynamicApiAutheticationCmsController;
use App\Modules\DynamicApiEngine\Http\Controllers\DynamicApiCmsController;
use App\Modules\DynamicApiEngine\Http\Controllers\DynamicApiEngineController;
use App\Modules\DynamicApiEngine\Http\Controllers\DynamicApiOperationsCmsController;
use App\Modules\DynamicApiEngine\Http\Controllers\DynamicApiOutputsCmsController;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'DynamicApiEngine', 'middleware' => []], function () {

    Route::any('d-api/{API_TYPE}/{OTHERS_PARAMETERS}', [DynamicApiEngineController::class, 'mainEngine']);

    Route::post('d-api/get-token', [DynamicApiAuthenticationController::class, 'handleTokenGenerationService']);
});


Route::group([
    'module' => 'DynamicApiEngine', 'middleware' => [
        'web',
        'auth', 'XssProtection'
    ]

], function () {

    Route::get('dynamic-api-engine/list', [DynamicApiCmsController::class, 'index']);
    // Route::get('settings/dynamic-api-engine/create', [DynamicApiCmsController::class, 'create']);
    Route::post('dynamic-api-engine/get-list', [DynamicApiCmsController::class, 'getApiList']);
    Route::post('dynamic-api-engine/delete-api', [DynamicApiCmsController::class, 'deleteApi']);
    Route::post('dynamic-api-engine/store-basic-info', [DynamicApiCmsController::class, 'storeApiBasicInfo']);

    Route::post('dynamic-api-engine/update-api-basic-info', [DynamicApiCmsController::class, 'updateApiBasicInfo']);
    Route::get('dynamic-api-engine/open-api/{id}', [DynamicApiCmsController::class, 'openApi']);
    Route::post('dynamic-api-engine/get-parameter-list', [DynamicApiCmsController::class, 'getParameterList']);
    Route::post('dynamic-api-engine/store-parameter-data', [DynamicApiCmsController::class, 'storeParameterData']);
    Route::post('dynamic-api-engine/get-parameter-content-for-validation', [DynamicApiCmsController::class, 'parameterValidationContent']);
    Route::post('dynamic-api-engine/get-parameter-content-for-edit', [DynamicApiCmsController::class, 'parameterEditContent']);
    Route::post('dynamic-api-engine/update-parameter-validation-data', [DynamicApiCmsController::class, 'updateParameterValidationData']);
    Route::post('dynamic-api-engine/update-parameter-name', [DynamicApiCmsController::class, 'updateParameterName']);
    Route::post('dynamic-api-engine/delete-api-parameter', [DynamicApiCmsController::class, 'deleteParameter']);

    Route::post('dynamic-api-engine/get-operation-list', [DynamicApiOperationsCmsController::class, 'getOperationList']);
    Route::post('dynamic-api-engine/store-operational-data', [DynamicApiOperationsCmsController::class, 'storeOperationalData']);
    Route::post('dynamic-api-engine/get-operation-data-for-edit', [DynamicApiOperationsCmsController::class, 'operationData']);
    Route::post('dynamic-api-engine/update-operational-data', [DynamicApiOperationsCmsController::class, 'updateOperationalData']);
    Route::post('dynamic-api-engine/delete-api-operation', [DynamicApiOperationsCmsController::class, 'deleteOperation']);

    Route::post('dynamic-api-engine/get-output-list', [DynamicApiOutputsCmsController::class, 'getOutputList']);
    Route::post('dynamic-api-engine/store-output-data', [DynamicApiOutputsCmsController::class, 'storeOutputData']);
    Route::post('dynamic-api-engine/get-output-data-for-edit', [DynamicApiOutputsCmsController::class, 'outputData']);
    Route::post('dynamic-api-engine/update-output-data', [DynamicApiOutputsCmsController::class, 'updateOutputData']);
    Route::post('dynamic-api-engine/delete-api-output', [DynamicApiOutputsCmsController::class, 'deleteOutput']);

    Route::get('dynamic-api-engine/authentications/list', [DynamicApiAutheticationCmsController::class, 'index']);
    Route::post('dynamic-api-engine/authentications/get-client-list', [DynamicApiAutheticationCmsController::class, 'getClientList']);
    Route::post('dynamic-api-engine/authentications/get-api-map-info', [DynamicApiAutheticationCmsController::class, 'apiMapInfo']);
    Route::post('dynamic-api-engine/authentications/store-api-map-info', [DynamicApiAutheticationCmsController::class, 'storeApiMapInfo']);
    Route::post('dynamic-api-engine/authentications/store-api-client-info', [DynamicApiAutheticationCmsController::class, 'storeApiClientInfo']);
    Route::post('dynamic-api-engine/authentications/get-api-client-info', [DynamicApiAutheticationCmsController::class, 'getApiClientInfo']);
    Route::post('dynamic-api-engine/authentications/update-api-client-info', [DynamicApiAutheticationCmsController::class, 'updateApiClientInfo']);
    Route::post('dynamic-api-engine/authentications/delete-api-client-info', [DynamicApiAutheticationCmsController::class, 'deleteApiClientInfo']);

});