<?php
use App\Http\Controllers\Frontend\HomePageController;
use App\Modules\Web\Http\Controllers\FrontPagesController;
use App\Modules\Web\Http\Controllers\VerifyDocController;
use App\Modules\Web\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'Web', 'middleware' => ['web', 'XssProtection']), function () {

    Route::get('/login/{lang}', [WebController::class, 'index']);
    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'WebController@switchLang']);
    Route::get('/', [WebController::class, 'index']);
    Route::get('/login', [WebController::class, 'index']);
    Route::post('login', ['as' => 'login', 'uses' => 'WebController@index']);
    Route::get('/login/{lang}', [WebController::class, 'index']);
    Route::get('web/notice', [WebController::class, 'notice']);
    Route::get('web/service-list', [WebController::class, 'serviceList']);
    Route::get('web/application-chart', [WebController::class, 'applicationChart']);
    Route::get('/viewNotice/{id}/{slug}', [WebController::class, 'viewNotice']);
    Route::get('/industrial-city-details/{id}', [WebController::class, 'industrialCityDetails']);
    Route::get('/need-help', [WebController::class, 'support']);
    Route::get('/log', [LogViewerController::class, 'index']);
    Route::get('/docs/{pdftype}/{id}', [VerifyDocController::class, 'verifyDoc']);
    Route::get('/docs/{id}', [VerifyDocController::class, 'verifyDoc']);
    Route::get('bscic-industrial-city/{city_id?}', [FrontPagesController::class, 'industrialCity'])->name('industrialCity.details');
    Route::get('article/{page_name}', [FrontPagesController::class, 'articlePage']);
    Route::get('web/load-more-notice', [WebController::class, 'loadMoreNotice']);
    Route::get('web/load-city-office', [WebController::class, 'loadCityOffice']);
    Route::get('/contact', [HomePageController::class, 'contact'])->name('frontend.contact');
    Route::get('about-us', [HomePageController::class, 'aboutUs'])->name('frontend.about_us');
    Route::get('user-menual', [HomePageController::class, 'userManual'])->name('frontend.user_manual');
    Route::get('/', [HomePageController::class, 'home'])->name('home');
    Route::get('messages-details/{id}', [HomePageController::class, 'messagesDetail'])->name('frontend.messages.detail');
    // Route::get('/login', [HomePageController::class, 'login'])->name('login');
    Route::get('/signup', [HomePageController::class, 'login'])->name('signup');
    Route::get('/login', [HomePageController::class, 'mobileLogin'])->name('login');
    Route::get('/email-login', [HomePageController::class, 'emailLogin'])->name('emailLogin');
    Route::get('course-view-more', [HomePageController::class, 'courseViewMore'])->name('courseViewMore');
    Route::get('/notice', [HomePageController::class, 'notice'])->name('frontend.notice_details');
    Route::get('/single-notice/{id}', [HomePageController::class, 'singleNotice'])->name('frontend.single_notice_details');
});
