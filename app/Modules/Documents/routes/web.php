<?php

use App\Modules\Documents\Http\Controllers\DocumentsController;
use App\Modules\Documents\Http\Controllers\UserCompanyDocuments;
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'Documents', 'middleware' => ['web', 'auth', 'checkAdmin', 'XssProtection']], function () {

    Route::get('documents/get-app-docs', [DocumentsController::class, 'getAppDocuments']);
    Route::post('documents/upload-document', [DocumentsController::class, 'uploadDocument']);

    Route::get('documents/get-user-documents', [UserCompanyDocuments::class, 'getUserDocuments']);
    Route::get('documents/upload-user-document/{doc_id}', [UserCompanyDocuments::class, 'userDocUploadModal']);
    Route::post('documents/update-user-document/{doc_id}', [UserCompanyDocuments::class, 'updateUserDocument']);
    Route::get('documents/lists', [UserCompanyDocuments::class, 'documentList']);
    Route::get('documents/get-user-document-history/', [UserCompanyDocuments::class, 'getDocumentHistory']);
});

