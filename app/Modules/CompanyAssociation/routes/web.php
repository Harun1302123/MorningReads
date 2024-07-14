<?php

use App\Modules\CompanyAssociation\Http\Controllers\CompanyAssociationController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'CompanyAssociation', 'prefix' => 'client',  'middleware' => ['web', 'auth',  'XssProtection']), function () {
    Route::get('company-association/create', [CompanyAssociationController::class, 'appForm']);
    Route::post('company-association/store', [CompanyAssociationController::class, 'storeCompanyAssociation']);
    Route::get('company-association/open/{id}', [CompanyAssociationController::class, 'appOpen']);
    Route::post('company-association/update', [CompanyAssociationController::class, 'appUpdate']);
    Route::get('company-association/status/{request_id}/{status_id}', [CompanyAssociationController::class, 'status_update']);
    Route::post('company-association/approve-reject', [CompanyAssociationController::class, 'companyActivatesAction']);
    Route::post('company-association/cancel-association', [CompanyAssociationController::class, 'cancelAssociation']);
});

/*
 * These url need to call without checkAdmin middleware.
 * because, company-association/select-company will redirect from checkAdmin if user does not select working company.
 * redirect url in checkAdmin middleware will generate error.
 */
Route::group(array('module' => 'CompanyAssociation', 'middleware' => ['web', 'auth', 'XssProtection']), function () {
    Route::get('company-association/select-company', [CompanyAssociationController::class, 'selectCompany']);
    Route::get('company-association/skip', [CompanyAssociationController::class, 'skipCompanyAssociation']);
    Route::post('company-association/update-working-company', [CompanyAssociationController::class, 'updateWorkingCompany']);
    Route::get('company-association/view/{id}/{openMode}', [CompanyAssociationController::class, 'appFormView']);
    Route::get('company-association/list', [CompanyAssociationController::class, 'getList']);
    //ob#code@start - Harun - getCompanyAssociationList method not found
    Route::post('company-association/get-list', [CompanyAssociationController::class, 'getCompanyAssociationList']);
});

Route::group(array('module' => 'CompanyAssociation', 'prefix' => 'client', 'middleware' => ['web', 'auth', 'XssProtection']), function () {
    Route::get('company-association/get-company-list', [CompanyAssociationController::class, 'getAssociationCompanyList']);
    Route::get('company-association/get-user-list/{company_id}', [CompanyAssociationController::class, 'getAssociationUserList']);
    Route::post('company-association/company-info', [CompanyAssociationController::class, 'associationCompanyInfo']);
});
