<?php
//ob#code@start - (galib) can use laravel's new routing

use App\Modules\CertificateGeneration\Http\Controllers\CertificateGenerationController;
use Illuminate\Support\Facades\Route;


Route::group(['module' => 'CertificateGeneration', 'middleware' => ['web']], function() {

    Route::get('certificate-generate/{cron_id?}', [CertificateGenerationController::class, 'generateCertificate']);

});
