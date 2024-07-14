<?php

use App\Modules\Users\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'Users', 'middleware' => ['web', 'auth', 'GlobalSecurity', 'checkAdmin', 'XssProtection']), function () {

    /* User related */
    Route::get('/users/lists', [UsersController::class, 'lists']);
    Route::get('users/view/{id}', [UsersController::class, 'view']);
    Route::patch('/users/update/{id}', [UsersController::class, 'update']);
    Route::get('/users/edit/{id}', [UsersController::class, 'edit']);
    Route::get('/users/activate/{id}', [UsersController::class, 'activate']);

    /* Assign parameters */
    Route::get('users/assign-parameters/{id}', [UsersController::class, 'assignParameters']);
    Route::post('users/assign-parameters-save', [UsersController::class, 'assignParametersSave']);

    Route::get('users/failedLogin-history/{id}', [UsersController::class, 'failedLoginHist']);
    Route::post('users/get-failed-login-data', [UsersController::class, 'getRowFailedData']);
    Route::post('users/failed-login-data-resolved', [UsersController::class, 'FailedDataResolved']);
    /* End of User related */

    /* New User Creation by Admin */
    Route::get('users/force-logout/{id}', [UsersController::class, 'forceLogout']);
    Route::post('users/identity-verify', [UsersController::class, 'identityVerifyConfirm']);
    Route::get('users/create-new-user', [UsersController::class, 'createNewUser']);
    Route::patch('/users/store-new-user', [UsersController::class, 'storeNewUser']);
    /* End of New User Creation by Admin */
});

// Only Login User can do it.
Route::group(array('module' => 'Users', 'middleware' => ['web', 'auth', 'GlobalSecurity','XssProtection']), function () {

    /* User profile update */
    Route::get('users/profileinfo', [UsersController::class, 'profileInfo']);
    Route::post('users/profile_updates/{id}', [
        'uses' => 'UsersController@profile_update'
    ]);
    Route::patch('users/update-password-from-profile', [UsersController::class, 'updatePassFromProfile']);

    /* User related */
    Route::post('users/get-access-log-data-for-self', [UsersController::class, 'getAccessLogDataForSelf']);

    Route::post('users/get-access-log-failed', [UsersController::class, 'getAccessLogFailed']);
    Route::post('users/get-last-50-actions', [UsersController::class, 'getLast50Actions']);
    Route::get('users/access-log/{id}', [UsersController::class, 'accessLogHist']);
    Route::get('users/get-access-log-data', [UsersController::class, 'accessLogHist']);
    Route::get('users/verify-nid', [UsersController::class, 'verifyNID']);

    /* Reset Password from profile and Admin list */
    Route::get('users/reset-password/{confirmationCode}', [
        'as' => 'confirmation_path',
        'uses' => 'UsersController@resetPassword'
    ]);

    /*
     * datatable
     */
    Route::post('users/get-user-list', [UsersController::class, 'getList']);
    Route::post('users/get-access-log-data/{id}', [UsersController::class, 'getAccessLogData']);
});

Route::group(array('module' => 'Users', 'middleware' => ['web', 'auth', 'checkAdmin','XssProtection']), function () {
    Route::get('users/delegate', [UsersController::class, 'delegate']);
    Route::get('users/remove-delegation/{id?}', [UsersController::class, 'removeDelegation']);
    Route::get('users/delegations/{id}', [UsersController::class, 'delegations']);
    Route::patch('users/process-delegation', [UsersController::class, 'processDelegation']);
    Route::patch('users/store-delegation', [UsersController::class, 'storeDelegation']);
    Route::post('users/get-delegate-userinfo', [UsersController::class, 'getDelegatedUserInfo']);
    Route::post('users/admin/get-delegate-user-list', [UsersController::class, 'getDelegateUserListForAdmin']);

});

// Without Authorization (Login is not required)
Route::group(array('module' => 'Users', 'middleware' => ['web']), function () {
    // verification
    Route::get('/users/verify-created-user/{encrypted_token}', [UsersController::class, 'verifyCreatedUser']);
    Route::patch('/users/created-user-verification/{encrypted_token}', [UsersController::class, 'createdUserVerification']);
    Route::patch('users/verification_store/{confirmationCode}', [
        'as' => 'confirmation_path',
        'uses' => 'UsersController@verification_store'
    ]);
    //ob#code@start - Harun - method not found
    Route::patch('users/store', [UsersController::class, 'store']);
    //Mail Re-sending
    Route::get('users/reSendEmail', [UsersController::class, 'reSendEmail']);
    Route::patch('users/reSendEmailConfirm', [UsersController::class, 'reSendEmailConfirm']);
    Route::post('/users/validateAutoCompleteData/{type}', [UsersController::class, 'validateAutoCompleteData']);
    //ob#code@end

    Route::get('/users/get-district-by-division', [UsersController::class, 'getDistrictByDivision']);
    Route::get('/users/get-thana-by-district-id', [UsersController::class, 'getThanaByDistrictId']);
    Route::get('users/get-user-session', [UsersController::class, 'getUserSession']);
    Route::post('users/resend-email-verification', [UsersController::class, 'resendVerification']);
    Route::get('users/resend-email-verification-from-admin/{enc_user_id}', [UsersController::class, 'resendVerificationFromAdmin']);
});

Route::group(array('module' => 'Users', 'middleware' => ['web', 'XssProtection']), function () {
    /*   To step Verification */
    Route::get('/users/two-step', [UsersController::class, 'twoStep']);
    Route::patch('/users/check-two-step', [UsersController::class, 'checkTwoStep']);
    Route::patch('/users/verify-two-step', [UsersController::class, 'verifyTwoStep']);
});