<?php

use App\Modules\Training\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;
use App\Modules\Training\Http\Controllers\TrCommonController;
use App\Modules\Training\Http\Controllers\TrCourseController;
use App\Modules\Training\Http\Controllers\TrCategoryController;
use App\Modules\Training\Http\Controllers\TrScheduleController;
use App\Modules\Training\Http\Controllers\TrSpeakerController;
use App\Modules\Training\Http\Controllers\TrAttendanceController;
use App\Modules\Training\Http\Controllers\TrEvaluationController;
use App\Modules\Training\Http\Controllers\TrCertificateController;
use App\Modules\Training\Http\Controllers\TrParticipantController;
use App\Modules\Training\Http\Controllers\TrainingSignupController;
use App\Modules\Training\Http\Controllers\TrNotificationController;
use App\Modules\Training\Http\Controllers\TrOrganizationController;

Route::group(['module' => 'Training', 'middleware' => ['auth', 'checkAdmin', 'XssProtection']], function () 
{

    Route::get('training/speaker/list', [TrSpeakerController::class, 'index']);
    Route::get('training/speaker/create-speaker', [TrSpeakerController::class, 'createSpeaker']);
    Route::post('training/get-speaker-data', [TrSpeakerController::class, 'getData']);
    Route::get('training/edit-speaker/{id}', [TrSpeakerController::class, 'editSpeaker']);


    Route::get('/users/lists', [TrScheduleController::class, 'index']);
    Route::get('training/schedule/list', [TrScheduleController::class, 'index']);
    Route::post('training/get-schedule-data', [TrScheduleController::class, 'getData']);
    Route::get('training/view-schedule-details/{id}', [TrScheduleController::class, 'scheduleDetails']);
    
    Route::get('training/category-list/get-image-and-category', [TrScheduleController::class, 'trainingCategoryGetImageByCategory']);
    Route::get('training/category-list', [TrCategoryController::class, 'index']);
    Route::post('training/get-category-data', [TrCategoryController::class, 'getData']);
    Route::get('training/create-category', [TrCategoryController::class, 'createCategory']);
    Route::post('training/store-category', [TrCategoryController::class, 'storeCategory']);
    Route::get('training/edit-category/{id}', [TrCategoryController::class, 'editCategory']);

    Route::get('training/course-list', [TrCourseController::class, 'index']);
    Route::post('training/get-course-data', [TrCourseController::class, 'getData']);
    Route::get('training/create-course', [TrCourseController::class, 'createCourse']);


    Route::get('training/view-schedule/{id}', [TrScheduleController::class, 'trainingDetails']);

    Route::get('training/schedule/check-batch-name', [TrScheduleController::class, 'checkBatchName']);

    Route::get('training/get-thana', [TrScheduleController::class, 'getThana']);

    //Common Route
    Route::get('training/get-batch-by-course-id', [TrCommonController::class, 'getBatchByCourseId']);
    Route::get('training/get-course-by-trScheduleMasterId', [TrCommonController::class, 'getSessionBytrScheduleMasterId']);

    //Notification
    Route::get('training/notification/list', [TrNotificationController::class, 'index']);
    Route::post('training/notification/get-data', [TrNotificationController::class, 'getData']);
    Route::get('training/notification/add-notification', [TrNotificationController::class, 'createNotification']);
    Route::post('training/notification/add-notification', [TrNotificationController::class, 'storeNotification']);

    //Participants Marks
    Route::get('training/evaluation/list', [TrEvaluationController::class, 'index']);
    Route::get('training/evaluation/create', [TrEvaluationController::class, 'evaluationCreate']);
    Route::get('training/participants-marks', [TrEvaluationController::class, 'participantsMarks']);
    Route::post('training/store-participant-marks-bulk', [TrEvaluationController::class, 'storeParticipantMarksBulk']);
    Route::post('training/evaluation/get-data', [TrEvaluationController::class, 'getData']);

    //Participants Attendance

    Route::get('training/attendance/create', [TrAttendanceController::class, 'attendanceCreate']);
    Route::post('training/attendance-entry', [TrAttendanceController::class, 'attendanceEntry']);
    Route::post('training/attendance-entry-all', [TrAttendanceController::class, 'attendanceEntryAll']);
    Route::get('training/get-participants-by-scheduleSessionId', [TrAttendanceController::class, 'getParticipantsBytrSessionMasterId']);


    Route::get('training/dashboard', [TrScheduleController::class, 'trainingDashboard']);
    Route::get('training/upcoming-course', [TrScheduleController::class, 'upcomingCourse']);
    Route::get('training/purchase-course', [TrScheduleController::class, 'purchaseCourse']);
    Route::get('training/course-details/{id}', [TrParticipantController::class, 'courseDetails']);
    Route::post('training/upload-document', [TrScheduleController::class, 'uploadDocument']);

    //Certificate
    Route::get('training/get-certificate/{part_id}/{course_id}', [TrCertificateController::class, 'participantCertificate']);
    Route::get('training/regenerate-certificate/{part_id}/{course_id}', [TrCertificateController::class, 'regenerateCertificate']);

    // TrParticipantController
    Route::post('training/enroll-participants/{id}', [TrParticipantController::class, 'enrollParticipantsWithoutPayment']);
    Route::get('training/afterPayment/{payment_id}', [TrParticipantController::class, 'afterPayment']);
    Route::post('training/participants-data/update', [TrParticipantController::class, 'updateParticipantsData']);
    Route::get('training/check-session-participant', [TrParticipantController::class, 'checkSessionParticipant']);
    Route::get('training/schedule/get-status-wise-user-list', [TrParticipantController::class, 'getstatusWiseTrainingUserData']);
    Route::get('training/schedule/download-participants/{id}', [TrParticipantController::class, 'downloadParticipantsAll']);
    Route::get('training/schedule-participant-info/{course_id}/{part_id}', [TrParticipantController::class, 'participantInfo']);
    Route::get('/training/schedule/get-user-list', [TrParticipantController::class, 'getUserData']);
    Route::get('training/schedule/participant-activates', [TrParticipantController::class, 'participantActivates']);

    //Organization

    Route::get('/training/organization/all-list', [TrOrganizationController::class, 'index']);
    Route::post('/training/organization/get-organization-data', [TrOrganizationController::class, 'getData']);
    Route::get('/training/organization/create-new', [TrOrganizationController::class, 'createData']);
    Route::post('/training/organization/store-data', [TrOrganizationController::class, 'storeData']);
    Route::get('/training/organization/edit-data/{id}', [TrOrganizationController::class, 'editData']);
    Route::post('/training/organization/update-data', [TrOrganizationController::class, 'storeData']);

});
Route::group(['module' => 'Training', 'middleware' => ['auth', 'checkAdmin'], ], function () 
{
    Route::post('training/store-schedule', [TrScheduleController::class, 'storeSchedule']);
    Route::post('training/update-schedule/{id}', [TrScheduleController::class, 'storeSchedule']);
    Route::get('training/edit-schedule/{id}', [TrScheduleController::class, 'editSchedule']);
    Route::get('training/create-schedule', [TrScheduleController::class, 'createSchedule']);
    Route::get('training/schedule-update/{id}', [TrScheduleController::class, 'scheduleUpdate']);

    Route::post('training/store-course', [TrCourseController::class, 'storeCourse']);
    Route::get('training/edit-course/{id}', [TrCourseController::class, 'editCourse']);
    Route::get('training/view-course/{id}', [TrCourseController::class, 'viewCourse']);


    Route::post('training/store-speaker', [TrSpeakerController::class, 'storeSpeaker']);
    Route::get('training/edit-speaker/{id}', [TrSpeakerController::class, 'editSpeaker']);
});

Route::group(['module' => 'Training', 'middleware' => ['XssProtection'], ], function () 
{   
    Route::get('web/training-list', [TrScheduleController::class, 'training']);
    Route::get('web/training-details/{id}', [TrScheduleController::class, 'trainingDetailsNew']);
    Route::get('web/get-training-data', [TrScheduleController::class, 'getTrainingData']);
    Route::get('web/training/filter-data', [TrScheduleController::class, 'getTrainingFilterData']);
});



Route::group(['module' => 'Training', 'middleware' => ['XssProtection'], ], function () 
{   
    Route::post('training/identity-verify', [TrainingSignupController::class, 'identityVerifyConfirm']);

});









