<?php

use App\Modules\SonaliPayment\Http\Controllers\IpnController;
use App\Modules\SonaliPayment\Http\Controllers\PaymentConfigController;
use App\Modules\SonaliPayment\Http\Controllers\PaymentInvoiceController;
use App\Modules\SonaliPayment\Http\Controllers\PaymentPanelController;
use App\Modules\SonaliPayment\Http\Controllers\SonaliPaymentController;
use Illuminate\Support\Facades\Route;
/*
 * All routes with 'spg/' prefix
 */

Route::group(['module' => 'SonaliPayment', 'prefix' => 'spg', 'middleware' => ['web', 'auth', 'GlobalSecurity', 'checkAdmin']], function () {
    //  Route::group(['prefix' => 'spg', 'module' => 'SonaliPayment', 'middleware' => ['web', 'auth', 'checkAdmin'], 'namespace' => 'App\Modules\SonaliPayment\Http\Controllers'], function () {

    // Routes for Payment Lists, open, verify by ref. no., history verify
    Route::get('initiate-multiple/{id}', [SonaliPaymentController::class, 'initiatePaymentMultiple']);
    Route::get('counter-payment-check/{id}/{status}', [SonaliPaymentController::class, 'counterPaymentCheck']);
    Route::get('offline-payment-verify', [SonaliPaymentController::class, 'offlinePaymentVerify']);
    Route::get('list', [SonaliPaymentController::class, 'index']);
    Route::post('getList', [SonaliPaymentController::class, 'paymentList']);
    Route::get('payment-history/{id}', [SonaliPaymentController::class, 'indivPaymentHistory']);
    Route::post('history-data/', [SonaliPaymentController::class, 'indivPaymentHistoryData']);
    Route::get('history-verify/{id}/{histId}', [SonaliPaymentController::class, 'verifyTransactionHistory']);
    Route::get('ref-verification/{id}', [SonaliPaymentController::class, 'verifyTransactionByRefNo']);
    Route::get('verifyAndComplete/{id}', [SonaliPaymentController::class, 'verifyAndComplete']);
    Route::get('daily-tansaction', [SonaliPaymentController::class, 'dailyTransaction']);
    Route::get('search', [SonaliPaymentController::class, 'getPaymentList']);
    // End Routes for Payment Lists, open, verify by ref. no., history verify


    // Routes for Payment configuration start
    Route::get('payment-configuration', [PaymentConfigController::class, 'paymentConfiguration']);
    Route::post('get-payment-configuration-details-data', [PaymentConfigController::class, 'getPaymentConfiguration']);
    Route::get('create-payment-configuration', [PaymentConfigController::class, 'paymentConfigurationCreate']);
    Route::post('store-payment-configuration', [PaymentConfigController::class, 'paymentConfigurationStore']);
    Route::get('edit-payment-configuration/{id}', [PaymentConfigController::class, 'editPaymentConfiguration']);
    Route::patch('update-payment-configuration/{id}', [PaymentConfigController::class, 'updatePaymentConfiguration']);
    Route::post('get-payment-distribution-data', [PaymentConfigController::class, 'getPaymentDistributionData']);
    Route::get('stakeholder-distribution/{payConfigID}', [PaymentConfigController::class, 'stakeholderDistribution']);
    Route::post('stakeholder-distribution', [PaymentConfigController::class, 'stakeholderDistributionStore']);
    Route::get('stakeholder-distribution-edit/{distributionId}', [PaymentConfigController::class, 'editStakeholderDistribution']);
    Route::post('stakeholder-distribution-update/{id}', [PaymentConfigController::class, 'stakeholderDistributionStore']);


    // End Routes for Payment configuration start

    // Payment invoice/ voucher routes
    Route::get('payment-voucher/{id}', [PaymentInvoiceController::class, 'paymentVoucher']);
    Route::get('counter-payment-voucher/{id}', [PaymentInvoiceController::class, 'counterPaymentVoucher']);



    Route::post('payment-panel', [PaymentPanelController::class, 'getPaymentPanel']);
    Route::post('payment/store', [PaymentPanelController::class, 'submitPayment']);



    Route::get('payment-view/{process_type_id}/{app_id}', [PaymentPanelController::class, 'getViewPaymentPanel']);
    Route::get('vue/payment-view/{process_type_id}/{app_id}', [PaymentPanelController::class, 'getViewPaymentPanelVue']);


});
Route::post('spg/callbackM', [SonaliPaymentController::class, 'callbackMultiple']);

/*
 * All routes with 'ipn/' prefix
 */
// Route::group(['prefix' => 'ipn', 'module' => 'SonaliPayment', 'middleware' => ['web', 'auth', 'checkAdmin'], 'namespace' => 'App\Modules\SonaliPayment\Http\Controllers'], function () {


Route::group(['module' => 'SonaliPayment', 'prefix' => 'ipn', 'middleware' => ['web', 'auth', 'GlobalSecurity', 'checkAdmin']], function () {
    Route::get('ipn-list', [IpnController::class, 'ipnList']);
    Route::post('get-list', [IpnController::class, 'getIpnList']);
    Route::get('ipn-history/{id}', [IpnController::class, 'ipnHistory']);

});