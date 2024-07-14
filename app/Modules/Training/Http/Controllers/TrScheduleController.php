<?php

namespace App\Modules\Training\Http\Controllers;

use App\Libraries\ACL;
use App\Modules\Settings\Models\Area;
use Illuminate\Http\Request;
use App\Libraries\Encryption;
use yajra\Datatables\Datatables;
use App\Libraries\CommonFunction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Modules\Training\Models\TrBatch;
use App\Modules\Training\Models\TrCourse;
use Illuminate\Support\Facades\Validator;
use App\Modules\Training\Models\TrCategory;
use App\Modules\Training\Models\TrSchedule;
use App\Modules\Training\Models\TrEvaluation;
use App\Modules\Training\Models\TrParticipant;
use App\Modules\Training\Models\TrScheduleSession;
use App\Modules\Training\Models\TrSpeaker;

class TrScheduleController extends Controller
{
    protected $process_type_id;
    protected $aclName;

    public function __construct()
    {
        $this->process_type_id = 700;
        $this->aclName = 'Training-Desk';
    }

    // route checked
    public function index()
    {
        if (!ACL::getAccsessRight($this->aclName, '-V-') && !ACL::getAccsessRight($this->aclName, '-DV-')) {
            die('You have no access right! Please contact system administration for more information');
        }
        return view('Training::tr_schedule.index');
    }

    // route checked
    public function createSchedule()
    {
        if (!ACL::getAccsessRight($this->aclName, '-A-')) {
            die('You have no access right! Please contact system administration for more information');
        }

        $trCourse = ['' => 'Select one'] + TrCourse::leftJoin('tr_schedules', 'tr_schedules.course_id', '=', 'tr_courses.id')->whereNull('tr_schedules.course_id')
        ->where('tr_courses.is_active', 1)->orderBy('tr_courses.id', 'DESC')->pluck('tr_courses.course_title', 'tr_courses.id')->all();
        
        $districts = ['' => 'Select One'] + Area::where('area_type', 2)->orderBy('area_nm', 'asc')->pluck('area_nm', 'area_id')->all();
        $thana = Area::orderby('area_nm')->where('area_type', 3)->pluck('area_nm', 'area_id');

        $speakers = ['' => 'Select One'] + TrSpeaker::where('is_active', 1)->orderBy('id', 'DESC')->pluck('speaker_name', 'id')->all();

        return view('Training::tr_schedule.create', compact( 'districts', 'thana', 'trCourse', 'speakers'));
    }

    // route checked
    public function getData()
    {
        if (!ACL::getAccsessRight($this->aclName, '-V-') && !ACL::getAccsessRight($this->aclName, '-DV-')) {
            die('You have no access right! Please contact system administration for more information');
        }
        if (checkTrainingCoordinator()) {
            $trainingData = TrScheduleSession::where('created_by', Auth::user()->id)->orderBy('id', 'DESC')->get();

            
        }elseif(checkTrainingDirector()){
            $trainingData = TrScheduleSession::where('is_publish', (int)request()->status)->where('is_active', 1)->orderBy('id', 'DESC')->get();
        }
        // dd($trainingData->schedule);
        return Datatables::of($trainingData)
            ->editColumn('course', function ($training) {
                return $training->schedules->course->course_title;
            })
            ->editColumn('day', function ($training) {
                return $training->session_days;
            })
            ->editColumn('time', function ($training) {
                return \Carbon\Carbon::createFromFormat('H:i:s', $training->session_start_time)->format('h:i A').' to '.\Carbon\Carbon::createFromFormat('H:i:s', $training->session_end_time)->format('h:i A');
            })
            ->editColumn('venue', function ($training) {
                return $training->schedules->venue;
            })
            ->editColumn('batch_no', function ($training) {
                return $training->session_name;
            })
            // ->editColumn('is_publish', function ($training) {
            //     if ($training->is_publish == 1) {
            //         return 'Yes';
            //     } else {
            //         return 'No';
            //     }
            // })
            ->addColumn('action', function ($training) {

                if(ACL::getAccsessRight('Training-Desk','-V-') || ACL::getAccsessRight('Training-Desk','-DV-') ) {
                    $button = '<a href="' . url('/training/view-schedule-details/' . Encryption::encodeId($training->schedules->id)) . '"  class="btn btn-xs btn-info "><i class="fa fa-eye"></i> Open </a> ';
                }
                
                if(($training->schedules->is_publish == 0 && ACL::getAccsessRight('Training-Desk','-DE-')) || ACL::getAccsessRight('Training-Desk','-E-') ) {
                    $button .= '<a href="' . url('/training/edit-schedule/' . Encryption::encodeId($training->schedules->id)) . '"  class="btn btn-xs btn-primary "><i class="fa fa-pencil"></i> Edit </a> ';
                }

                if($training->schedules->is_publish == 0  && checkTrainingDirector() && ACL::getAccsessRight('Training-Desk','-DE-')) {
                    $button .= '<a href="' . url('/training/schedule-update/'.Encryption::encodeId($training->schedules->id)) . '"  class="btn btn-xs btn-info "><i class="fas fa-check"> Approve </a>';
                }

                return $button;
            })
            ->rawColumns(['action'])
            ->removeColumn('id')
            ->make(true);
    }

    // route checked
    public function storeSchedule(Request $request)
    {
        if(!empty($request->get('app_id'))){
            if(checkTrainingCoordinator()){
                $mode = '-E-';
            }
            else{
                $mode = '-DE-';
            }
        }
        else{
            $mode = '-A-';
        }
        if (!ACL::getAccsessRight($this->aclName, $mode)) {
            abort('400', "You have no access right! Please contact system administration for more information");
        }
        
        $rules = [
            'session_name' => 'required',
            'course_id' => 'required',
            'course_duration_start' => 'required|date',
            'course_duration_end' => 'required|date',
            'total_hours' => 'required',
            'no_of_class' => 'required',
            'enroll_deadline' => 'required',
            'district_id' => 'required|integer',
            'thana_id' => 'required|integer',
            'venue' => 'required',
            'no_of_batch' => 'required',
            'expect_start' => 'required',
            'course_thumbnail_path' => 'required',
            'objectives' => 'required',
            'course_contents' => 'required',
            'necessary_qualification_experience' => 'required',
        ];


        $messages = [
            'session_name.required' => 'Session name is required',
            'course_id.required' => 'Course is required',
            'course_duration_start.required' => 'Course duration start is required',
            'course_duration_end.required' => 'Course duration end is required',
            'total_hours.required' => 'Total hours is required',
            'no_of_class.required' => 'No of class is required',
            'enroll_deadline.required' => 'Enroll deadline is required',
            'district_id.required' => 'District is required',
            'thana_id.required' => 'Thana is required',
            'venue.required' => 'Venue is required',
            'no_of_batch.required' => 'No of batch is required',
            'expect_start.required' => 'Expect start is required',
            'objectives.required' => 'Objectives is required',
            'course_contents.required' => 'Course contents is required',
            'necessary_qualification_experience.required' => 'Necessary qualification experience is required',
        ];
        if($request->get('app_id')){
            $rules['course_thumbnail_path'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:1024';
            $rules['status'] = 'required';
            $rules['is_publish'] = 'required';
        }
        else{
            $rules['course_thumbnail_path'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024';
        }
        foreach ($request->input('session_name') as $index => $value) {
            $rules['session_name.' . $index] = 'required|string|max:255';
            $rules['session_start_time.' . $index] = 'required';
            $rules['session_end_time.' . $index] = 'required';
            $rules['day.' . $index] = 'required';
            $rules['speaker_id.' . $index] = 'required';
    
            // Custom messages
            $messages['session_name.' . $index . '.required'] = 'The session name at row ' . ($index + 1) . ' is required.';
            $messages['session_start_time.' . $index . '.required'] = 'The session start time at row ' . ($index + 1) . ' is required.';
            $messages['session_end_time.' . $index . '.required'] = 'The session end time at row ' . ($index + 1) . ' is required.';
            $messages['session_end_time.' . $index . '.after'] = 'The session end time must be after the start time at row ' . ($index + 1) . '.';
            $messages['day.' . $index . '.required'] = 'Please select at least one day at row ' . ($index + 1) . '.';
            $messages['seat_capacity.' . $index . '.numeric'] = 'The seat capacity at row ' . ($index + 1) . ' must be a number.';
            $messages['speaker_id.' . $index . '.required'] = 'The seat capacity at row ' . ($index + 1) . ' is required.';
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            Log::error('TRSchedule : ' . $validator->errors() . ' [TRS-684]');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            if ($request->get('app_id')) {
                $appId = Encryption::decodeId($request->get('app_id'));
                $trSchedule = TrSchedule::find($appId);
                $msg = 'Schedule updated successfully';

            }else {
                $trSchedule = new TrSchedule();
                $trSchedule->created_by = Auth::user()->id;
                $msg = 'Schedule created successfully';
            }
            $trSchedule->status = $request->status ?? 'upcoming';
            $trSchedule->course_id = $request->course_id;
            $trSchedule->course_duration_start = date('Y-m-d', strtotime($request->course_duration_start));
            $trSchedule->course_duration_end = date('Y-m-d', strtotime($request->course_duration_end));
            $trSchedule->total_hours = $request->total_hours;
            $trSchedule->no_of_class = $request->no_of_class;
            $trSchedule->enroll_deadline = date('Y-m-d', strtotime($request->enroll_deadline));
            $trSchedule->district_id = $request->district_id;
            $trSchedule->thana_id = $request->thana_id;
            $trSchedule->venue = $request->venue;
            $trSchedule->no_of_batch = $request->no_of_batch;
            $trSchedule->expect_start = date('Y-m-d', strtotime($request->expect_start));
           
            $trSchedule->objectives = $request->objectives;
            $trSchedule->course_contents = $request->course_contents;
            $trSchedule->necessary_qualification_experience = $request->necessary_qualification_experience;
            $trSchedule->is_publish = $request->is_publish ?? 0;
            if($request->hasFile('course_thumbnail_path')){
                $yearMonth = date("Y") . "/" . date("m") . "/";
                $path = 'uploads/training/course/' . $yearMonth;
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $_file_path = $request->file('course_thumbnail_path');
                $file_path = trim(uniqid('TR_C01-' . time() . '-', true) . $_file_path->getClientOriginalName());
                $_file_path->move($path, $file_path);
                $trSchedule->course_thumbnail_path = $yearMonth . $file_path;
            }
            $trSchedule->save();


            if (!empty($request->session_start_time[0])) {
                $session_ids = [];
                foreach ($request->session_start_time as $key => $data) {

                    if ($request->get('app_id') && $request->get('tr_session_id')[$key] != '') {
                        $trSessionIid = $request->get('tr_session_id')[$key];
                        $trSession = TrScheduleSession::find($trSessionIid);
                    }else {
                        $trSession = new TrScheduleSession();
                    }
                    $trSession->session_name = $request->session_name[$key];
                    $trSession->app_id = $trSchedule->id;
                    $trSession->session_start_time = date("H:i", strtotime($request->session_start_time[$key]));
                    $trSession->session_end_time = date("H:i", strtotime($request->session_end_time[$key]));
                    $sessionDaysArray = $request->day[$key];
                    $days = implode(',', $sessionDaysArray);
                    $trSession->session_days = $days;
                    $trSession->seat_capacity = $request->seat_capacity[$key] ? $request->seat_capacity[$key] : '';
                    $trSession->speaker_id = $request->speaker_id[$key];
                    $trSession->is_active = 1;
                    $trSession->save();

                    $session_ids[] = $trSession->id;
                }

                if ($request->get('app_id') && count($session_ids) > 0) {
                    TrScheduleSession::where('app_id', $trSchedule->id)->whereNotIn('id', $session_ids)->delete();
                }
            }
            return redirect('training/schedule/list')->with('success', $msg);

        } catch (\Exception $e) {
            Log::error('TRSchedule : ' . $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine() . ' [TRS-73]');
            return response()->json([
                'responseCode' => 1,
                'html' => "<attachment_typeh4 class='custom-err-msg'>" . CommonFunction::showErrorPublic($e->getMessage()) . ' [TRS-73]' . "</attachment_typeh4>",
            ]);
        }
        
    }

    // route checked
    public function editSchedule($id)
    {
        if(checkTrainingCoordinator()){
            $mode = '-E-';
        }
        else{
            $mode = '-DE-';
        }
        if (!ACL::getAccsessRight($this->aclName, $mode)) {
            die('You have no access right! Please contact system administration for more information');
        }
        // $trCourse = ['' => 'Select one'] + TrCourse::where('is_active', 1)->orderBy('id', 'DESC')->pluck('course_title', 'id')->all();
        $tr_data = TrSchedule::find(Encryption::decodeId($id));

        $trCourse = TrCourse::where('is_active', 1)
            ->where(function($query) use ($tr_data) {
                $query->whereDoesntHave('schedule')
                    ->orWhere('id', $tr_data->course_id);
            })
            ->orderBy('id', 'DESC')
            ->pluck('course_title', 'id')
            ->all();

        $trCourse = ['' => 'Select one'] + $trCourse;



        $districts = ['' => 'Select One'] + Area::where('area_type', 2)->orderBy('area_nm',
        'asc')->pluck('area_nm', 'area_id')->all();
        $thana = Area::orderby('area_nm')->where('area_type', 3)->pluck('area_nm', 'area_id');
        $speakers = ['' => 'Select One'] + TrSpeaker::where('is_active', 1)->orderBy('id', 'DESC')->pluck('speaker_name', 'id')->all();

        $trSessionData = TrScheduleSession::where('app_id', $tr_data->id)->get();
        return view('Training::tr_schedule.edit', compact('tr_data', 'id', 'trSessionData', 'districts', 'thana', 'trCourse','speakers'));
    }

    
    public function scheduleUpdate($id){

        if (!ACL::getAccsessRight($this->aclName, '-DE-')) {
            die('You have no access right! Please contact system administration for more information');
        }

        if(checkTrainingDirector()){
            $decodeId = Encryption::decodeId($id);
            $course = TrSchedule::where('id', $decodeId)->first();  
            $course->is_publish = 1;
            $course->is_active = 1;
            $course->update();

            return redirect()->back()->with('success', 'Schedule Approve successfully');
        }
        
        return redirect()->back()->with('error', 'You Do not have permission to update this schedule');

    }

    // route checked
    public function training(Request $request)
    {
        $course = TrSchedule::where('is_active', 1)->where('is_publish', 1)->orderBy('id', 'DESC')->get();
        $total_category = TrCategory::where('is_active', 1)->count();
        $total_participants = TrParticipant::where('is_active', 1)->count();

        return view('Training::web.training_list', compact('course', 'total_category', 'total_participants'));
    }

    // route checked
    public function trainingDetailsNew($id)
    {
        $decodeId = Encryption::decodeId($id);
        $course = TrSchedule::where('id', $decodeId)->first();
        $scheduleSession = TrScheduleSession::where('app_id', $decodeId)->get();
        //$courseList = TrSchedule::where('is_active', 1)->where('is_publish', 1)->where('category_id', $course->category_id)->get();
        $course_url = url("training/course-details/$id");
        //put session course url
        Session::put('training_course_url', $course_url);
        if (Auth::check()) {
            $redirect_url = $course_url;
        }else{
            $redirect_url = CommonFunction::getOssPidRedirectUrl();
        }
        return view('Training::web.training_details', compact('course', 'scheduleSession', 'redirect_url'));
    }

    // route checked
    public function trainingDetails($id)
    {
        $course = TrSchedule::where('id', $id)->first();
        return view("Training::course-details", compact('course'));
    }

    // route checked
    public function trainingCategoryGetImageByCategory(Request $request)
    {
        if(checkTrainingCoordinator()){
            $mode = '-E-';
        }
        else{
            $mode = '-DE-';
        }
        if (!ACL::getAccsessRight($this->aclName, $mode)) {
            die('You have no access right! Please contact system administration for more information');
        }
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way [Ajax-1001]';
        }
        try {
            $tr_course_id = trim($request->get('course_id'));
            $course = TrCourse::where('id', $tr_course_id)->first();
            $category = TrCategory::where('id', $course->category_id)->first();
            return response()->json(
                [
                    'responseCode' => 1,
                    'img_path' => asset('/uploads/training/course/' . $course->course_image),
                    'img_value' => !empty($course->course_image) ? $course->course_image : '',
                    'img_path2' => asset('/uploads/training/course/' . $course->course_image2),
                    'img_value2' => !empty($course->course_image2) ? $course->course_image2 : '',
                    'img_path3' => asset('/uploads/training/course/' . $course->course_image3),
                    'img_value3' => !empty($course->course_image3) ? $course->course_image3 : '',
                    'category_id' => $category->id,
                    'message' => 'course category and image found.',
                ]

            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'responseCode' => 0,
                    'img_path' => asset('assets/images/no-image.png'),
                    'img_value' => '',
                    'category_id' => '',
                    'message' => 'Something in wrong in course image and category !',
                ]
            );
        }
    } // end -:- trainingCategoryGetImageByCategory()

    // route checked
    public function upcomingCourse()
    {
        $course = TrSchedule::where('is_active', 1)
                    ->where('is_publish', 1)
                    ->where('status', 'upcoming')
                    ->orderBy('id', 'DESC')
                    ->get();

        return view('Training::upcoming-course', compact('course'));
    }

    // route checked
    public function purchaseCourse()
    {

        $course = TrParticipant::leftJoin('tr_schedules', 'tr_schedules.id', '=', 'tr_participants.schedule_id')
            ->leftJoin('tr_courses', 'tr_courses.id', '=', 'tr_schedules.course_id')
            ->leftJoin('tr_evaluations', 'tr_evaluations.participant_id', '=', 'tr_participants.id')
            ->where('tr_participants.is_active', 1)
            ->where('tr_participants.is_paid', 1)
            ->where('tr_participants.created_by', Auth::user()->id)
            ->get(['tr_participants.*', 'tr_courses.course_title', 'tr_schedules.*']);


        return view('Training::upcoming-course-user', compact('course'));
    }

    // route checked
    public function uploadDocument()
    {
        return view('Training::ajaxUploadFile');
    }

    // route checked
    public function scheduleDetails($id)
    {
        if(!ACL::getAccsessRight($this->aclName, '-V-') && !ACL::getAccsessRight($this->aclName, '-DV-')){
            die('You have no access right! Please contact system administration for more information');
        }
        $decodeId = Encryption::decodeId($id);
        $course = TrSchedule::where('id', $decodeId)->first();
        $perticipants = TrParticipant::where('schedule_id', $decodeId)->get();
        return view('Training::tr_schedule.training_schedule', compact('course', 'perticipants'));
    }

    // route checked
    public function getTrainingData(Request $request)
    {
        $status = $request->status;
        if($status == 'allCourse'){
            $course = TrSchedule::where('is_active', 1)->where('is_publish', 1)->orderBy('id', 'DESC')->get();
        }
        else{
            $course = TrSchedule::where('is_active', 1)->where('is_publish', 1)->where('status', $status)->orderBy('id', 'DESC')->get();
        }
        return view('Training::web.training_list_status', compact('course'));
    }

    // route checked
    public function getTrainingFilterData(Request $request)
    {
        $name = $request->txtSearch;
        $course = TrSchedule::where('is_active', 1)->where('is_publish', 1)
            ->whereHas('course', function ($query) use ($name) {
                $query->where('course_title', 'like', '%' . $name . '%');
            })
            ->get();
        return view('Training::web.training_list_status', compact('course'));
    }

    // route checked
    public function trainingDashboard(Request $request)
    {
        $upcoming = TrSchedule::where('status', 'upcoming')->count();
        $ongoing = TrSchedule::where('status', 'ongoing')->count();
        $completed = TrSchedule::where('status', 'completed')->count();

        return view('Training::dashboard.tr_dashboard', compact('upcoming', 'ongoing', 'completed'));
    }

    public function getThana(Request $request)
    {
        $district_id = $request->district_id;
        $thana = Area::where('area_type', 3)
            ->where('pare_id', $district_id)
            ->orderBy('area_nm', 'asc')
            ->pluck('area_nm', 'area_id');

        $options = [];
        foreach ($thana as $id => $name) {
            $options[] = ['id' => $id, 'name' => $name];
        }

        return response()->json($options);
    }


}
