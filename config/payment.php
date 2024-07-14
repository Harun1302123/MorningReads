<?php

return [
    'spg_settings_stack_holder' => [
        'web_service_url' => env('SPG_WEB_SERVICE_URL'),
        'web_portal_url' => env('SPG_WEB_PORTAL_URL'),
        'user_id' => env('SPG_USER_ID'),
        'password' => env('SPG_PASSWORD'),
        'SBL_account' => env('SPG_SBL_ACCOUNT'),
        'st_code' => env('ST_CODE'),
        'request_id_prefix' => env('SPG_REQUEST_ID_PREFIX'),
        'return_url' => env('PROJECT_ROOT') . '/spg/stack-holder/callback',
    ],

    'spg_settings' => [
        'payment_mode' => env('SPG_PAYMENT_MODE', 'on'),
        'web_service_url' => env('SPG_WEB_SERVICE_URL', 'https://spg.com.bd:6313/SpgService.asmx'),
        'web_portal_url' => env('SPG_WEB_PORTAL_URL', 'https://spg.com.bd:6313/SpgRequest/PaymentByPortal'),
        'single_details_url' => env('SPG_SINGLE_DETAILS_URL', 'https://spg.com.bd:6313/api/SpgService/TransactionDetails'),
        'user_id' => env('SPG_USER_ID', 'bdtaxUser2014'),
        'password' => env('SPG_PASSWORD', 'duUserPayment2014'),
        'sbl_account' => env('SPG_SBL_ACCOUNT', '0002634313655'),
        'st_code' => env('SPG_ST_CODE', 'OSS-Framework'),
        'request_id_prefix' => env('SPG_REQUEST_ID_PREFIX', '010'),
        'return_url' => env('PROJECT_ROOT') . env('SPG_CALLBACK_URL', '/spg/callback'),
        'return_url_m' => env('PROJECT_ROOT') . env('SPG_CALLBACK_URL_M', '/spg/callbackM'),
    ]
];
