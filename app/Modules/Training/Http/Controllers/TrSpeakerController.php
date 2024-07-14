<?php

namespace App\Modules\Training\Http\Controllers;

use App\Libraries\ACL;
use Illuminate\Http\Request;
use App\Libraries\Encryption;
use yajra\Datatables\Datatables;
use App\Libraries\CommonFunction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Modules\Training\Models\TrSpeaker;
use Illuminate\Support\Facades\Validator;
use App\Modules\Settings\Models\Area;


class TrSpeakerController extends Controller
{
    protected $process_type_id;
    protected $aclName;

    public function __construct()
    {
        $this->process_type_id = 700;
        $this->aclName = 'Training';
    }

    // route checked
    public function index()
    {
        if (!ACL::getAccsessRight($this->aclName, '-V-') && !ACL::getAccsessRight($this->aclName, '-DV-')) {
            die('You have no access right! Please contact system administration for more information');
        }
        return view('Training::speaker.index');
    }

    // route checked
    public function createSpeaker()
    {
        if (!ACL::getAccsessRight($this->aclName, '-A-')) {
            die('You have no access right! Please contact system administration for more information');
        }
        $districts = Area::orderBy('area_nm', 'asc')->pluck('area_nm', 'area_id')->toArray();
        return view('Training::speaker.create', compact('districts'));
    }

    // route checked

    public function getData()
    {

        if (!ACL::getAccsessRight($this->aclName, '-V-')) {
            die('You have no access right! Please contact system administration for more information');
        }
              
        $speakerData = TrSpeaker::where('created_by', Auth::user()->id)->orderBy('id', 'DESC')
        ->get(['id', 'speaker_name', 'speaker_email','speaker_mobile', 'is_active']);
        return Datatables::of($speakerData)
            ->editColumn('name', function ($speaker) {
                return $speaker->speaker_name;
            })
            ->editColumn('email', function ($speaker) {
                return $speaker->speaker_email;
            })
            ->editColumn('mobile', function ($speaker) {
                return $speaker->speaker_mobile;
            })
            ->editColumn('status', function ($speaker) {
                $activate = $speaker->is_active == 1 ? "btn-success" : "btn-danger" ;
                $status_name = $speaker->is_active == 1 ? 'Active' : 'Inactive';
                return '<span class="btn-xs '.$activate.'"><b>' . $status_name . '</b></span>';
            })
        
            ->addColumn('action', function ($training) {
                $button = '<a href="' . url('/training/edit-speaker/' . Encryption::encodeId($training->id)) . '"  class="btn btn-xs btn-primary "><i class="fa fa-pencil"></i> Edit </a> ';
                
                return $button;
            })
            ->rawColumns(['status', 'action'])
            ->removeColumn('id')
            ->make(true);
    }

    // route checked
    public function storeSpeaker(Request $request)
    {
        if (!ACL::getAccsessRight($this->aclName, '-A-')) {
            abort('400', "You have no access right! Please contact system administration for more information");
        }
        $rules = [
            'speaker_name' => 'required',
            'gender' => 'required',
            'speaker_email' => 'required',
            'speaker_mobile' => 'required',
            'designation' => 'required',
            'organization' => 'required',
            'is_active' => 'required|in:1,0',

        ];

        $messages = [
            'speaker_name.required' => 'Speaker Name is required',
            'gender.required' => 'Gender is required',
            'speaker_email.required' => 'Speaker email Category is required',
            'speaker_mobile.required' => 'Speaker mobile is required',
            'designation.required' => 'Designation is required',
            'organization.required' => 'Organization is required',
            'is_active.required' => 'Status is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            Log::error('TRspeaker : ' . $validator->errors() . ' [TRS-684]');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            if ($request->get('app_id')) {
                $appId = Encryption::decodeId($request->get('app_id'));
                $trSpeaker = TrSpeaker::find($appId);
            }else {
                $trSpeaker = new TrSpeaker();
            }
            $trSpeaker->speaker_name = $request->speaker_name;
            $trSpeaker->designation = $request->designation;
            $trSpeaker->organization = $request->organization;
            $trSpeaker->gender = $request->gender;
            $trSpeaker->speaker_email = $request->speaker_email;
            $trSpeaker->speaker_mobile = $request->speaker_mobile;
            $trSpeaker->district = $request->district;
            $trSpeaker->thana = $request->thana;
            $trSpeaker->is_active = $request->is_active;
            $trSpeaker->save();

            
        } catch (\Exception $e) {
            Log::error('TrSpeaker : ' . $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine() . ' [TRS-73]');
            return response()->json([
                'responseCode' => 1,
                'html' => "<attachment_typeh4 class='custom-err-msg'>" . CommonFunction::showErrorPublic($e->getMessage()) . ' [TRS-73]' . "</attachment_typeh4>",
            ]);
        }
        if ($request->get('app_id')) {
            return redirect('training/speaker/list')->with('success', 'Speaker updated successfully');

        }else {
            return redirect('training/speaker/list')->with('success', 'Speaker created successfully');

        }
    }

    // route checked
    public function editSpeaker($id)
    {
        if (!ACL::getAccsessRight($this->aclName, '-E-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }

        $tr_data = TrSpeaker::find(Encryption::decodeId($id));
        return view('Training::speaker.edit', compact('tr_data'));
    }


}
