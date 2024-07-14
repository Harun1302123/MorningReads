<?php
//ob#code@start - (galib) use laravel's new routing and remove unused element

use App\Modules\Settings\Http\Controllers\DocumentSettingsController;
use App\Modules\Settings\Http\Controllers\IndustrialCityController;
use App\Modules\Settings\Http\Controllers\MasterPlanController;
use App\Modules\Settings\Http\Controllers\SettingsController;
use App\Modules\Settings\Http\Controllers\SettingsControllerV2;
use App\Modules\Settings\Http\Controllers\MessageController;
use App\Modules\Settings\Http\Controllers\AboutUsController;
use App\Modules\Settings\Http\Controllers\ContactSettingController;
use App\Modules\Settings\Http\Controllers\UserManualController;
use App\Modules\Settings\Http\Controllers\NoticeController;

use Illuminate\Support\Facades\Route;


Route::group(array('module' => 'Settings', 'middleware' => ['web', 'auth']), function () {

    Route::get('/settings/get-district-by-division-id', [SettingsController::class, 'get_district_by_division_id']);
    Route::get('settings/get-police-stations', [SettingsController::class, 'getPoliceStations']);
    Route::get('settings/get-district-user', [SettingsController::class, 'getDistrictUser']);
});

/* *************************************************
 * All routes for Common OSS Feature
 * Please, Do not write project basis routes here.
 ************************************************* */
Route::group(array('module' => 'Settings', 'middleware' => ['web', 'auth', 'checkAdmin']), function () {
    //****** Maintenance Mode  ****//
    Route::get('settings/maintenance-mode', [SettingsController::class, 'maintenanceMode']);
    //ob#code@start - Harun - method not found
    Route::get('settings/maintenance-mode/get-users-list', [SettingsController::class, 'getMaintenanceUserList']);
    //ob#code@end
    Route::get('settings/maintenance-mode/remove-user/{user_id}', [SettingsController::class, 'removeUserFromMaintenance']);
    Route::post('settings/maintenance-mode/store', [SettingsController::class, 'maintenanceModeStore']);

    //ob#code@start - Harun - DisplaySettingsController class not found
    //*********** Display Device ******************//
    Route::get('settings/display-settings/display-device', [DisplaySettingsController::class, 'displayDeviceList']);
    Route::get('settings/display-settings/get-display-device-data', [DisplaySettingsController::class, 'getDisplayDeviceData']);
    Route::get('settings/display-settings/create-display-device', [DisplaySettingsController::class, 'createNewDisplayDevice']);
    Route::post('settings/display-settings/store-display-device', [DisplaySettingsController::class, 'storeDisplayDevice']);
    Route::get('settings/display-settings/edit-display-device/{id}', [DisplaySettingsController::class, 'editDisplayDevice']);
    Route::patch('settings/display-settings/update-display-device/{id}', [DisplaySettingsController::class, 'updateDisplayDevice']);
    Route::get('settings/display-settings/show-request-history/{id}', [DisplaySettingsController::class, 'showRequestHistoryDevice']);
    //ob#code@end

    //ob#code@start - Harun - ServerInfoController class not found
    //*********** Server Info ******************//
    Route::get('settings/server-info', [ServerInfoController::class, 'serverInfo']);
    //ob#code@end
    //****** Application Rollback  ****//
    Route::get('settings/app-rollback', [SettingsController::class, 'applicationRollbackList']);
    Route::post('settings/app-rollback/list', [SettingsController::class, 'getApplicationList']);
    Route::get('settings/app-rollback-search', [SettingsController::class, 'applicationSearch']);
    Route::post('settings/app-rollback-open', [SettingsController::class, 'applicationRollbackOpen']);
    Route::post('settings/app-rollback/update', [SettingsController::class, 'applicationRollbackUpdate']);
    Route::post('settings/get-user-by-desk', [SettingsController::class, 'getUserByDesk']);
    Route::get('settings/app-rollback-view/{id}', [SettingsController::class, 'viewApplicationRollback']);


    //****** Forcefully data update update ****//
    Route::get('settings/forcefully-data-update', [SettingsController::class, 'forcefullyDataUpdate']);
    Route::post('settings/get-forcefully-data-update-data', [SettingsController::class, 'getForcefullyDataList']);
    Route::get('settings/create-forcefully-data-update', [SettingsController::class, 'createForcefullyDataUpdate']);
    Route::post('settings/store-forcefully-data-update', [SettingsController::class, 'storeForcefullyDataUpdate']);
    Route::post('settings/approve-forcefully-data-update', [SettingsController::class, 'approveForcefullyDataUpdate']);
    Route::get('settings/forcefully-data-update-view/{id}', [SettingsController::class, 'singleForcefullyViewById']);

});


/* *************************************************
 * All routes for Project Basis setup
 *
 * Please, write all project basis routes in below
 * and use the ProjectSettingsController.php file
 ************************************************* */
Route::group(array('module' => 'Settings', 'middleware' => ['web', 'auth', 'checkAdmin']), function () {
    //for vue js
    //****** Bank List ****//
    Route::get('settings/bank-list-v2', [SettingsControllerV2::class, 'bankv2']);
    Route::get('settings/edit-bank-v2/{id}', [SettingsControllerV2::class, 'editBankv2']);
    Route::post('settings/store-bank-v2', [SettingsControllerV2::class, 'storeBankv2']);
    Route::get('settings/bank-list-v2-get', [SettingsControllerV2::class, 'BankListv2']);
    //ob#code@start - Harun - method not found
    Route::get('settings/bank-list-v2/delete/{id}', [SettingsControllerV2::class, 'softDeleteBank']);
    //ob#code@end
    Route::post('settings/update-bank-v2/{id}', [SettingsControllerV2::class, 'updateBankv2']);
    //****** Branch List ****//
    Route::get('settings/branch-list-v2-get', [SettingsControllerV2::class, 'BranchListv2']);
    Route::get('settings/store-branch', [SettingsControllerV2::class, 'storeBranch']);
    Route::post('settings/update-branch/{id}', [SettingsControllerV2::class, 'storeAndUpdateBranch']);
    Route::get('settings/get-bank-name', [SettingsControllerV2::class, 'bankName']);

//****** Notice List ****//
    // Route::get('settings/notice-list', [SettingsControllerV2::class, 'NoticeList']);
    // Route::post('settings/store-notice', [SettingsControllerV2::class, 'storeNotice']);
    // Route::get('settings/edit-notice/{id}', [SettingsControllerV2::class, 'editNotice']);
    // Route::post('settings/update-notice/{id}', [SettingsControllerV2::class, 'updateNotice']);

//****** Currency List ****//
    Route::get('settings/currency-list', [SettingsControllerV2::class, 'CurrencyList']);
    Route::post('settings/store-currency', [SettingsControllerV2::class, 'StoreCurrency']);
    Route::get('settings/edit-currency/{id}', [SettingsControllerV2::class, 'editCurrency']);
    Route::patch('settings/update-currency/{id}', [SettingsControllerV2::class, 'updateCurrency']);

//****** Service List ****//
    Route::get('settings/get-service-name', [SettingsControllerV2::class, 'serviceName']);
    Route::get('settings/document-list', [SettingsControllerV2::class, 'DocumentList']);
    Route::post('settings/store-document', [SettingsControllerV2::class, 'StoreDocument']);
    Route::get('settings/edit-document/{id}', [SettingsControllerV2::class, 'editDocument']);
    Route::patch('settings/update-document/{id}', [SettingsControllerV2::class, 'updateDocument']);

    //ob#code@start - Harun - method not found
    //****** Act & Rules List ****//
    Route::get('settings/act-rules-list', [SettingsControllerV2::class, 'ActRulesList']);
    Route::post('settings/store-act-rules', [SettingsControllerV2::class, 'StoreActRules']);
    Route::get('settings/edit-act-rules/{id}', [SettingsControllerV2::class, 'editActRules']);
    Route::post('settings/update-act-rules', [SettingsControllerV2::class, 'updateActRules']);
    //ob#code@end

//****** Area List ****//
    Route::get('settings/get-division-name', [SettingsControllerV2::class, 'divisionName']);
    Route::get('settings/get-thana-by-district-id', [SettingsControllerV2::class, 'get_thana_by_district_id']);
    Route::get('settings/get-district', [SettingsControllerV2::class, 'getDistrict']);
    Route::get('settings/area-list', [SettingsControllerV2::class, 'AreaList']);
    Route::post('settings/store-area', [SettingsControllerV2::class, 'StoreArea']);
    Route::get('settings/edit-area/{id}', [SettingsControllerV2::class, 'editArea']);
    Route::patch('settings/update-area/{id}', [SettingsControllerV2::class, 'updateArea']);

//****** Terms & Condition List ****//
    Route::get('settings/terms-condition', [SettingsControllerV2::class, 'TermsConditionList']);
    Route::post('settings/store-terms-condition', [SettingsControllerV2::class, 'StoreTermsCondition']);
    Route::get('settings/edit-terms-condition/{id}', [SettingsControllerV2::class, 'editTermsCondition']);
    Route::post('settings/update-terms-condition', [SettingsControllerV2::class, 'updateTermsCondition']);

//****** Company Info List ****//
    Route::get('settings/company-info', [SettingsControllerV2::class, 'CompanyInfoList']);
    Route::get('settings/get-country-name', [SettingsControllerV2::class, 'CountryName']);
    Route::post('settings/store-company-info', [SettingsControllerV2::class, 'StoreCompanyInfo']);
    Route::get('settings/company-info-edit/{id}', [SettingsControllerV2::class, 'companyInfoAction']);
    //ob#code@start - Harun - method not found
    Route::get('settings/approved-change-status/{company_id}', [SettingsControllerV2::class, 'companyApprovedStatus']);
    Route::get('settings/rejected-change-status/{company_id}', [SettingsControllerV2::class, 'companyRejectedStatus']);
    //ob#code@end
    Route::get('settings/company-change-status/{id}/{status_id}', [SettingsControllerV2::class, 'companyChangeStatus']);

    //****** Rejected Draft Company ****//
    Route::get('settings/rejected-draft-company-list', [SettingsControllerV2::class, 'rejectedDraftCompanyList']);
    Route::get('settings/rejected-draft-company-change-status/{id}', [SettingsControllerV2::class, 'rejectedDraftCompanyReject']);

    //****** user type List ****//
    Route::get('settings/user-type-list', [SettingsControllerV2::class, 'userTypeList']);
    Route::get('settings/edit-user-type/{id}', [SettingsControllerV2::class, 'editUserType']);
    Route::get('settings/get-security-list', [SettingsControllerV2::class, 'getSecurityList']);
    Route::patch('settings/update-user-type/{id}', [SettingsControllerV2::class, 'updateUserType']);

    //****** user-manual List ****//
    Route::get('settings/user-manual', [SettingsControllerV2::class, 'UserManualList']);
    Route::post('settings/home-page/store-user-manual', [SettingsControllerV2::class, 'UsermanualStore']);
    Route::get('settings/home-page/edit-user-manual/{id}', [SettingsControllerV2::class, 'editUsermanual']);
    Route::post('settings/home-page/update-user-manual', [SettingsControllerV2::class, 'updateUsermanual']);

    //****** whats-new List ****//
    Route::get('settings/whats-new', [SettingsControllerV2::class, 'WhatsNewList']);
    Route::post('settings/home-page/store-whats-new', [SettingsControllerV2::class, 'whatsNewStore']);
    Route::get('settings/home-page/edit-whats-new/{id}', [SettingsControllerV2::class, 'editWhatsNew']);
    Route::post('settings/home-page/update-whats-new', [SettingsControllerV2::class, 'updateWhatsNew']);

    //****** home-page-content List ****//
    Route::get('settings/home-page/home-page-content', [SettingsControllerV2::class, 'homeContentList']);
    Route::post('settings/home-page/store-home-page-content', [SettingsControllerV2::class, 'homeContentStore']);
    Route::get('settings/home-page/edit-home-page-content/{id}', [SettingsControllerV2::class, 'edithomeContent']);
    Route::post('settings/home-page/update-home-page-content', [SettingsControllerV2::class, 'updatehomeContent']);

    //****** Industrial city List ****//
    Route::get('settings/home-page/industrial-city', [IndustrialCityController::class, 'industrialCityList']);
    Route::post('settings/home-page/store-industrial-city', [IndustrialCityController::class, 'industrialCityStore']);
    Route::get('settings/home-page/edit-industrial-city/{id}', [IndustrialCityController::class, 'editIndustrialCity']);
    Route::post('settings/home-page/update-industrial-city', [IndustrialCityController::class, 'updateIndustrialCity']);
    Route::get('settings/get-upazila-name', [IndustrialCityController::class, 'upazilaName']);
    Route::get('/settings/get-upazila-by-district-id', [IndustrialCityController::class, 'getUpazila']);
    Route::get('/settings/home-page/get-homeOffice', [IndustrialCityController::class, 'getHomeoffice']);

    Route::get('settings/home-page/industrial-city/master-plan-list/{city_id}', [MasterPlanController::class, 'masterPlanList']);
    Route::post('settings/home-page/industrial-city/master-plan/create', [MasterPlanController::class, 'createMasterPlan']);
    Route::get('settings/home-page/industrial-city/master-plan/edit/{city_id}', [MasterPlanController::class, 'editMasterPlanDetails']);
    Route::post('settings/home-page/industrial-city/master-plan/update', [MasterPlanController::class, 'updateMasterPlanDetails']);

    //****** home-page-articles ****//
    Route::get('settings/home-page/home-page-articles', [SettingsControllerV2::class, 'homeArticlesList']);
    Route::post('settings/home-page/store-home-page-articles', [SettingsControllerV2::class, 'homeArticlesStore']);
    Route::get('settings/home-page/edit-home-page-articles/{id}', [SettingsControllerV2::class, 'edithomeArticles']);
    Route::post('settings/home-page/update-home-page-articles', [SettingsControllerV2::class, 'updatehomeArticles']);

    //ob#code@start - Harun - IndustrialAdvisorController class not found
    //****** industrial advisor ****//
    Route::get('settings/home-page/industrial-advisor', [IndustrialAdvisorController::class, 'IndustrialAdvisorList']);
    Route::post('settings/home-page/store-industrial-advisor', [IndustrialAdvisorController::class, 'IndustrialAdvisorStore']);
    Route::get('settings/home-page/edit-industrial-advisor/{id}', [IndustrialAdvisorController::class, 'editIndustrialAdvisor']);
    Route::post('settings/home-page/update-industrial-advisor', [IndustrialAdvisorController::class, 'updateIndustrialAdvisor']);
    //ob#code@end

    //****** home-page-slider List ****//
    Route::get('settings/home-page/home-page-slider-list', [SettingsControllerV2::class, 'HomePageSliderList']);
    Route::post('settings/home-page/store-home-page-slider', [SettingsControllerV2::class, 'homePageSliderStore']);
    Route::get('settings/home-page/edit-home-page-slider/{id}', [SettingsControllerV2::class, 'editHomePageSlider']);
    Route::post('settings/home-page/update-home-page-slider', [SettingsControllerV2::class, 'updateHomePageSlider']);

    //****** message ****//
    Route::get('settings/home-page/message', [MessageController::class, 'index'])->name('message.list');
    Route::get('settings/home-page/message/create', [MessageController::class, 'create'])->name('message.create');
    Route::post('settings/home-page/message/store', [MessageController::class, 'store'])->name('message.store');
    Route::get('settings/home-page/message/edit/{id}', [MessageController::class, 'edit'])->name('message.edit');

    //****** About Us ****//
    Route::get('settings/home-page/about-us', [AboutUsController::class, 'index'])->name('about-us.list');
    Route::post('settings/home-page/about-us/store', [AboutUsController::class, 'store'])->name('about-us.store');
    Route::get('settings/home-page/about-us/edit/{id}', [AboutUsController::class, 'edit'])->name('about-us.edit');


    //****** Contact Settings ****//
    Route::get('settings/home-page/contact-setting', [ContactSettingController::class, 'index'])->name('contact-setting.list');
    Route::post('settings/home-page/contact-setting/store', [ContactSettingController::class, 'store'])->name('contact-setting.store');
    Route::get('settings/home-page/contact-setting/edit', [ContactSettingController::class, 'edit'])->name('contact-setting.edit');

    //****** user manual  ****//
    Route::get('settings/home-page/user-manual', [UserManualController::class, 'index'])->name('user-manual.list');
    Route::get('settings/home-page/user-manual/create', [UserManualController::class, 'create'])->name('user-manual.create');
    Route::post('settings/home-page/user-manual/store', [UserManualController::class, 'store'])->name('user-manual.store');
    Route::get('settings/home-page/user-manual/edit/{id}', [UserManualController::class, 'edit'])->name('user-manual.edit');

    //****** notice ****//
    Route::get('settings/home-page/notice', [NoticeController::class, 'index'])->name('notice.list');
    Route::get('settings/home-page/notice/create', [NoticeController::class, 'create'])->name('notice.create');
    Route::post('settings/home-page/notice/store', [NoticeController::class, 'store'])->name('notice.store');
    Route::get('settings/home-page/notice/edit/{id}', [NoticeController::class, 'edit'])->name('notice.edit');

    //****** PdfPrintRequests List ****//
    Route::get('settings/pdf-print-requests', [SettingsControllerV2::class, 'pdfPrintRequest']);
    Route::get('settings/resend-pdf-print-requests/{id}' , [SettingsControllerV2::class, 'resendPdfPrintRequest']);
    Route::get('settings/edit-pdf-print-requests/{id}' , [SettingsControllerV2::class, 'editPdfPrintRequest']);
    Route::get('/settings/update-pdf-print-requests/{id}', [SettingsControllerV2::class, 'updatePdfPrintRequest']);
    Route::get('settings/pdf-print-request-verify/{pdf_id}/{certificate_name}', [SettingsControllerV2::class, 'verifyPdfPrintRequest']);

    //****** Email-SMS-Query List ****//
    Route::get('settings/email-sms-query', [SettingsControllerV2::class, 'emailSmsQueryList']);
    Route::get('settings/email-sms-query-edit/{id}', [SettingsControllerV2::class, 'editEmailSmsQuery']);
    Route::patch('settings/update-email-sms-query/{id}', [SettingsControllerV2::class, 'updateEmailSmsQuery']);
    Route::get('settings/resend-email-sms-query/{id}/{type}', [SettingsControllerV2::class, 'resendEmailSmsQuery']);

    //****** Security List ****//
    Route::get('settings/security', [SettingsControllerV2::class, 'SecurityList']);
    Route::post('settings/store-security', [SettingsControllerV2::class, 'storeSecurity']);
    Route::get('settings/edit-security/{id}', [SettingsControllerV2::class, 'editSecurity']);
    Route::post('settings/update-security/{id}', [SettingsControllerV2::class, 'updateSecurity']);

    //ob#code@start - Harun - RegulatoryAgencyController class not found
    //****** Regulatory Agency List ****//
    Route::get('settings/home-page/regulatory-agency', [RegulatoryAgencyController::class, 'RegulatoryAgencyList']);
    Route::post('settings/home-page/store-regulatory-agency', [RegulatoryAgencyController::class, 'storeRegulatoryAgency']);
    Route::get('settings/home-page/edit-regulatory-agency/{id}', [RegulatoryAgencyController::class, 'editRegulatoryAgency']);
    Route::post('settings/home-page/update-regulatory-agency', [RegulatoryAgencyController::class, 'updateRegulatoryAgency']);
    //****** Regulatory Agency List ****//
    Route::get('settings/home-page/regulatory-agency-details', [RegulatoryAgencyController::class, 'RegulatoryAgencyDetailsList']);
    Route::get('settings/home-page/regulatory-agency-details/regulatory-agency', [RegulatoryAgencyController::class, 'RegulatoryAgencyName']);
    Route::post('settings/home-page/store-regulatory-agency-details', [RegulatoryAgencyController::class, 'storeRegulatoryAgencyDetails']);
    Route::get('settings/home-page/edit-regulatory-agency-details/{id}', [RegulatoryAgencyController::class, 'editRegulatoryAgencyDetails']);
    Route::post('settings/home-page/update-regulatory-agency-details', [RegulatoryAgencyController::class, 'updateRegulatoryAgencyDetails']);
    //ob#code@end


    //****** Logo List ****//
    Route::post('settings/update-logo', [SettingsControllerV2::class, 'storeLogo']);
    Route::get('settings/logo-edit', [SettingsControllerV2::class, 'editLogo']);
    //****** service-details List ****//
    Route::get('settings/service-details', [SettingsControllerV2::class, 'ServiceDetailsList']);
    Route::get('settings/service-details-create', [SettingsControllerV2::class, 'createServiceDetails']);
    Route::get('settings/service-details-edit/{id}', [SettingsControllerV2::class, 'editServiceDetails']);
    Route::post('settings/service-details-store', [SettingsControllerV2::class, 'storeServiceDetails']);
    Route::post('settings/service-details-update', [SettingsControllerV2::class, 'updateServiceDetails']);

    //****** Application Guideline List ****//
    Route::get('settings/application-guideline', [SettingsControllerV2::class, 'applicationGuideline']);
    Route::get('settings/get-guideline', [SettingsControllerV2::class, 'applicationGuidelineList']);
    Route::get('settings/application-guideline/create', [SettingsControllerV2::class, 'applicationGuidelineCreate']);
    Route::post('settings/application_guideline/store', [SettingsControllerV2::class, 'applicationGuidelineStore']);
    Route::get('settings/application-guideline/edit/{id}', [SettingsControllerV2::class, 'applicationGuidelineEdit']);
    Route::post('settings/application-guideline/update', [SettingsControllerV2::class, 'applicationGuidelineUpdate']);



//****** Soft Delete ****//
    Route::get('settings/delete/{model}/{id}', [SettingsControllerV2::class, 'softDelete']);


    //****** Maintenance Mode  ****//
//    Route::get('settings/maintenance-mode-list', "SettingsControllerV2@maintenanceModeget");
//    Route::get('settings/maintenance-mode/remove-user/{user_id}', "SettingsControllerV2@removeUserFromMaintenance");
//    Route::post('settings/maintenance-mode/store', "SettingsControllerV2@maintenanceModeStore");



//ob#code@start - (galib) the routes and method names are confusing, one is used for process document crud, other is for document name crud
    Route::get('settings/document-v2', [DocumentSettingsController::class, 'index']);
    Route::get('settings/document-v2/document-list', [DocumentSettingsController::class, 'getDocumentList']);
    Route::get('settings/document-v2/create', [DocumentSettingsController::class, 'createDocument']);
    Route::get('settings/document-v2/edit/{document_id}', [DocumentSettingsController::class, 'editDocument']);
    Route::post('settings/document-v2/store', [DocumentSettingsController::class, 'storeDocument']);
    Route::post('settings/document-v2/update/{document_id}', [DocumentSettingsController::class, 'storeDocument']);
    Route::post('settings/document-v2/get-document-type', [DocumentSettingsController::class, 'getDocumentType']);

    Route::get('settings/document-v2/service-document-list', [DocumentSettingsController::class, 'getServiceDocumentList']);
    Route::get('settings/document-v2/service/create', [DocumentSettingsController::class, 'createServiceDocument']);
    Route::get('settings/document-v2/service/edit/{service_doc_id}', [DocumentSettingsController::class, 'editServiceDocument']);
    Route::post('settings/document-v2/service/store', [DocumentSettingsController::class, 'storeServiceDocument']);
    Route::post('settings/document-v2/service/update/{service_doc_id}', [DocumentSettingsController::class, 'storeServiceDocument']);

//ob#code@end - (galib)

// Route to handle page reload in Vue except for api routes
    Route::get('settings/{index?}', [SettingsControllerV2::class, 'index'])->where('index', '(.*)');

//    Route::get('settings/{index?}', 'SettingsControllerV2@branch')->where('index', '(.*)');


});
