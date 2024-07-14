<?php

use App\Modules\Signup\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;


Route::group(array('module' => 'Signup', 'prefix' => 'client', 'middleware' => ['web', 'XssProtection']), function () {
    Route::get('signup/identity-verify', [SignupController::class, 'identityVerify']);
    Route::get('signup/identity-verify/tin-verify', [SignupController::class, 'nidTinVerify'])->name('nidTinVerify');
    Route::get('signup/identity-verify/nid-tin-verify', [SignupController::class, 'nidVerifyRequest']);
    Route::get('signup/getPassportData', [SignupController::class, 'getPassportData']);
    Route::post('signup/identity-verify', [SignupController::class, 'identityVerifyConfirm']);
    Route::post('signup/identity-verify-previous/{id}', [SignupController::class, 'identityVerifyConfirmWithPreviousData']);
    Route::get('signup/registration', [SignupController::class, 'OSSsignupForm']);
    Route::post('signup/registration', [SignupController::class, 'OSSsignupStore']);
    Route::post('signup/getPassportData', [
        'as' => 'getPassportData',
        'uses' => 'SignupController@getPassportData'
    ]);
    Route::match(['get', 'post'], 'signup/identity-verify-otp', 'SignupController@identityVerifyOtp')->name('signup.identity_verify_otp');
    Route::post('signup/otp-verify', 'SignupController@otpVerify')->name('signup.otp_verify');
});

