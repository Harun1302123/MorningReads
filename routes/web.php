<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\OSSPIDLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('login/load-login-otp-form', [LoginController::class, 'loadLoginOtpForm']);
Route::post('login/otp-login-validation-with-token-provide', [LoginController::class, 'otpLoginMobileValidationWithTokenProvide']);
// Route::post('login/otp-login-validation-with-token-provide', [LoginController::class, 'otpLoginEmailValidationWithTokenProvide']);
Route::post('login/otp-login-check', [LoginController::class, 'checkOtpLogin']);
Route::post('login/otp-resent', [LoginController::class, 'OtpResent']);
Route::post('login/check-sms-send-status', [LoginController::class, 'checkSMSstatus']);

//Route::group(array('middleware' => ['auth']), function () {
//    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
//});

Route::group(array('middleware' => []), function () {
    Route::get('/sso-login', [LoginController::class, 'ssoLogin']);
    Route::get('/get-cookie', [LoginController::class, 'getCookie']);
});




/*
 * Google Login routes
 */
Route::get('auth/google', [GoogleLoginController::class, 'redirectToProvider']);
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleProviderCallback']);
Route::get('oauth/google/callback', [GoogleLoginController::class, 'handleProviderCallback']);


//OSSPID LOGIN and signup
Route::get('osspid-callback', [OSSPIDLoginController::class, 'osspidCallback']);
Route::get('osspid_signUp', [OSSPIDLoginController::class, 'osspid_signUp']);
Route::patch('osspid/store', [OSSPIDLoginController::class, 'OsspidStore']);
Route::get('osspid/logout', [OSSPIDLoginController::class, 'osspidLogout'])->name('osspid_logout');

//Route::group(array('middleware' => ['auth']), function () {
//    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
//});

//General LOGIN and signup
Route::post('login/check', [LoginController::class, 'check']);

/*bscic attachment*/

Route::get('bscic-attachment/{fileurl}', [CommonController::class, 'getAttachment']);

// Forget password routes
Route::get('re-captcha', [LoginController::class, 'reCaptcha']);
Route::get('forget-password', [LoginController::class, 'forgetPassword']);
Route::post('reset-forgotten-password', [LoginController::class, 'resetForgottenPass']);
Route::get('verify-forgotten-pass/{token_no}', [LoginController::class, 'verifyForgottenPass']);
Route::post('store-forgotten-password', [LoginController::class, 'StoreForgottenPass']);

Route::get('articles/support', [ArticlesController::class, 'aboutQuickServicePortal']);



Route::group(array('middleware' => ['auth']), function () {
    Route::get('common/activities/activities-summary', [CommonController::class, 'activitiesSummary']);
});
