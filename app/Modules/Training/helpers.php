<?php

use App\Libraries\CommonFunction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modules\Training\Models\TrParticipant;
use App\Modules\Training\Models\TrSchedule;
use App\Modules\Training\Models\TrScheduleSession;
use App\Modules\Users\Models\Users;

/*
    training module
    start
*/

function traineeUserType()
{
    return "10x112";
}

function checkUserTrainingDesk()
{
    return Auth::user()->desk_training_id;
}

function userTrainingDesk()
{
    if(checkTrainingCoordinator()){
        return "Coordinator";
    }elseif(checkTrainingDirector()){
        return "Director";
    }
    
}

function checkTrainingCoordinator()
{
    return checkUserTrainingDesk() == 1;
}

function checkTrainingDirector()
{
    return checkUserTrainingDesk() == 2;
}

function checkTrainee()
{
    return Auth::user()->user_type == traineeUserType();
}

function checkUserPermissionTraining()
{
    $user_type = Auth::user()->user_type;
    $type = explode("x", $user_type); // $type[0] is user type first segment
    if(in_array($type[0], ["10","1",'5']) || ($type[0] == "4" && checkUserTrainingDesk())){
        return true;
    }

    return false;
}


function generateCertificateNumber($batch_name, $year)
{   
    $prefix = "TB-$batch_name-$year-";
    $lastNumber = getLastCertificateNumber($prefix);
    return $prefix.nextSegmentNumber($lastNumber);
}

function nextSegmentNumber($lastNumber)
{
    if ($lastNumber) {
        $nextSegment = sprintf('%04d', $lastNumber + 1);
    } else {
        $nextSegment = '0001';
    }

    return $nextSegment;
}

function getLastCertificateNumber($prefix)
{
    return TrParticipant::query()
        ->select(DB::raw('SUBSTRING(certificate_no, LENGTH(certificate_no) - 3) AS last_number'))
        ->where('certificate_no', 'like', "$prefix%")
        ->orderBy('last_number', 'DESC')
        ->limit(1)
        ->value('last_number');

}


function training_slider_image()
{
    $currentDate = date('Y-m-d');

    $trSchedules = TrSchedule::where('is_active', 1)
        ->where('status', 'upcoming')
        ->where('is_publish', 1)
        ->where('is_featured', 1)
        ->where('enroll_deadline', '>=', $currentDate) // Add this line
        ->orderBy('id', 'DESC')
        ->take(5)
        ->get();

    return $trSchedules;

}

function checkUserDeskNone()
{
    $user_desk_ids = CommonFunction::getUserDeskIds();
    if(!in_array(0, $user_desk_ids) && !in_array(99, $user_desk_ids)){
        return true;
    }
    return false;
}

function checkSeatAbility($schedule_id, $session_id)
{
    $schedule = TrScheduleSession::find($session_id);
    if($schedule->applicant_limit == 'limit'){
        $total_seat = $schedule->seat_capacity;
        $enrolled = TrParticipant::where('schedule_id', $schedule_id)->where('session_id', $session_id)->count();
        if($total_seat > $enrolled){
            return true;
        }
        return false;
    }
    else{
        return true;
    }
    
}

function trainingCoordinatorList()
{
    return Users::query()
        ->where('desk_training_id', 1)
        ->pluck('user_first_name', 'id');

}

function userFullName($id)
{
    return Users::query()
        ->where('id', $id)
        ->value('user_first_name');

}