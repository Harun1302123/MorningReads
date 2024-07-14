<?php

use App\Modules\CompanyProfile\Http\Controllers\AppSubDetailsController;
use App\Modules\CompanyProfile\Http\Controllers\CompanyProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'CompanyProfile', 'prefix' => 'client', 'middleware' => ['web','auth','GlobalSecurity']], function() {

    Route::get('company-profile/create', [CompanyProfileController::class, 'create']);
    Route::get('company-profile/create/{id}', [CompanyProfileController::class, 'create']);
    Route::get('company-profile/get-country-by-investment-type', [CompanyProfileController::class, 'getCountryByInvestmentType']);
    Route::get('company-profile/get-industry-type-by-investment', [CompanyProfileController::class, 'getIndustryByInvestment']);
    Route::get('company-profile/get-sub-sector-by-sector', [CompanyProfileController::class, 'getSubSectorBySector']);
//  store company profile
    Route::post('company-profile/store', [CompanyProfileController::class, 'storeCompany']);
    Route::post('company-profile/upload-document', [CompanyProfileController::class, 'uploadDocument']);
    Route::get('company-profile/get-company-profile', [CompanyProfileController::class, 'getCompanyProfile']);
    Route::get('company-profile/get-edit-info', [CompanyProfileController::class, 'getEditInfo']);
//    update company profile
    Route::patch('company-profile/update-general-info', [CompanyProfileController::class, 'updateGeneralInfo']);
    Route::patch('company-profile/update-office-info', [CompanyProfileController::class, 'updateOfficeInfo']);
    Route::patch('company-profile/update-factory-info', [CompanyProfileController::class, 'updateFactoryInfo']);
    Route::patch('company-profile/update-ceo-info', [CompanyProfileController::class, 'updateCeoInfo']);
    Route::post('company-profile/update-signature-info', [CompanyProfileController::class, 'updateSignatureInfo']);
    Route::post('company-profile/update-signatureImage', [CompanyProfileController::class, 'updateSignatureImage']);
    Route::patch('company-profile/update-activities-info', [CompanyProfileController::class, 'updateActivitiesInfo']);

    //director section
    Route::get('company-profile/create-director', [AppSubDetailsController::class, 'loadUserIdentificationModal']);
    Route::get('company-profile/edit-director/{id}', [AppSubDetailsController::class, 'editDirector']);
    Route::post('company-profile/store-verify-director-session', [AppSubDetailsController::class, 'storeVerifyDirectorSession']);
    Route::post('company-profile/update-director-session', [AppSubDetailsController::class, 'updateDirectorSession']);
    Route::get('company-profile/delete-director-session/{id}', [AppSubDetailsController::class, 'deleteDirectorSession']);
    Route::post('company-profile/load-listof-directors', [AppSubDetailsController::class, 'loadListOfDirectors']);
    Route::post('company-profile/load-listof-directors-session', [AppSubDetailsController::class, 'loadListOfDirectorsSession']);
    Route::get('company-profile/set-single-director-info', [AppSubDetailsController::class, 'setSingleDirectorInfo']);


    Route::get('company-profile/create-info', [AppSubDetailsController::class, 'createInfo']);
    Route::get('company-profile/create-info/{id}', [AppSubDetailsController::class, 'createInfo']);
    Route::get('company-profile/select-director-info', [AppSubDetailsController::class, 'selectDirectorInfo']);

// Director from db
    Route::get('company-profile/edit-director-db/{id}', [AppSubDetailsController::class, 'editDirectorDB']);
    Route::get('company-profile/delete-director-db/{id}', [AppSubDetailsController::class, 'deleteDirectorDB']);
    Route::patch('company-profile/update-company-director-info', [CompanyProfileController::class, 'updateCompanyDirectorInfo']);

});
