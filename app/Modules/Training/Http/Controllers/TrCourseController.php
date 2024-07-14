<?php

namespace App\Modules\Training\Http\Controllers;

use App\Libraries\ACL;
use Illuminate\Http\Request;
use App\Libraries\Encryption;
use yajra\Datatables\Datatables;
use App\Libraries\CommonFunction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Modules\Training\Models\Organization;
use Illuminate\Support\Facades\Validator;
use App\Modules\Training\Models\TrCourse;
use App\Modules\Training\Models\TrCategory;

class TrCourseController extends Controller
{
    protected $process_type_id = 2202;
    protected $aclName = 'Training-Desk';

    public function index(){
        if (!ACL::getAccsessRight($this->aclName, '-DA-')) {
            die('You have no access right! Please contact system administration for more information');
        }
        return view('Training::course.index');
    }

    public function createCourse(){
        
        if (!ACL::getAccsessRight($this->aclName, '-DA-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }
        $trCategory = TrCategory::where('is_active', 1)->pluck('category_name', 'id');
        $organizations = Organization::where('is_active', 1)->pluck('organization_name', 'id');
        return view('Training::course.create', compact('trCategory','organizations'));
    }

    public function getData(){
        if (!ACL::getAccsessRight($this->aclName, '-DA-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }
        $courseData = TrCourse::orderBy('id', 'desc')
        ->get();
        return Datatables::of($courseData)
            ->editColumn('course_title', function ($course) {
                return $course->course_title;
            })
            ->editColumn('status', function ($course) {
                $activate = $course->is_active == 1 ? "btn-success" : "btn-danger" ;
                $status_name = $course->is_active == 1 ? 'Active' : 'Inactive';
                return '<span class="btn-xs '.$activate.'"><b>' . $status_name . '</b></span>';
            })
            ->addColumn('action', function ($course) {
                $editButton = '<a href="' . url('/training/edit-course/' . Encryption::encodeId($course->id)) . '"  class="btn btn-xs btn-primary "><i class="fa fa-pencil"></i> Edit </a> ';
                
                // $viewButton = '<a href="' . url('/training/view-course/' . Encryption::encodeId($course->id)) . '"  class="btn btn-xs btn-secondary "><i class="fa fa-eye"></i> View </a> ';
            
                // return $editButton . $viewButton;
                return $editButton;
            })
            
            ->rawColumns(['status', 'action'])
            ->removeColumn('id')
            ->make(true);
    }

    public function storeCourse(Request $request){
        // Set permission mode and check ACL
          $mode = (!empty($request->get('app_id')) ? '-DE-' : '-DA-');
          if (!ACL::getAccsessRight($this->aclName, $mode)) {
              abort('400', "You have no access right! Please contact system administration for more information");
          }
  
        $rules = [
            'course_title' => 'required',
            'training_organization' => 'required',
            'training_authority' => 'required',
            'training_coordinator' => 'required',
            'training_location' => 'required',
            'company_name' => 'required',

        ];

        $messages = [
            'course_title.required' => 'Course title is required',
            'training_organization.required' => 'Organization is required',
            'training_authority.required' => 'Authority is required',
            'training_coordinator.required' => 'Coordinator is required',
            'training_location.required' => 'Location is required',
            'company_name.required' => 'Company is required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            if ($request->get('app_id')) {
                $appId = Encryption::decodeId($request->get('app_id'));
                $trCourse = TrCourse::find($appId);
                $msg = 'Course updated successfully';
            }else {
                $trCourse = new TrCourse();
                $msg = 'Course created successfully';
            }
            $trCourse->course_title = $request->get('course_title');
            $trCourse->training_organization = $request->get('training_organization');
            $trCourse->training_authority = $request->get('training_authority');
            $trCourse->training_coordinator = $request->get('training_coordinator');
            $trCourse->training_location = $request->get('training_location');
            $trCourse->training_company = $request->get('company_name');
            $trCourse->save();

            return redirect('training/course-list')->with('success', $msg);
           
        }
        catch (\Exception $e) {
            Log::error('TrCourse : ' . $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine() . ' [TRC-127]');
            return response()->json([
                'responseCode' => 1,
                'html' => "<attachment_typeh4 class='custom-err-msg'>" . CommonFunction::showErrorPublic($e->getMessage()) . ' [TRC-127]' . "</attachment_typeh4>"
            ]);
        }
        

    }

    public function editCourse($id){
        if (!ACL::getAccsessRight($this->aclName, '-DE-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }

        $tr_data = TrCourse::find(Encryption::decodeId($id));
        $organizations = Organization::where('is_active', 1)->pluck('organization_name', 'id');

        return view('Training::course.edit', compact('tr_data','id','organizations'));
    }

    public function viewCourse($id){
        if (!ACL::getAccsessRight($this->aclName, '-DE-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }
        $trCategory = TrCategory::where('is_active', 1)->pluck('category_name', 'id');
        $tr_data = TrCourse::find(Encryption::decodeId($id));
        $coordinatorLabels = ['1' => 'RD1', '2' => 'RD2'];

        return view('Training::course.view', compact('tr_data','id','trCategory','coordinatorLabels'));
    }


}
