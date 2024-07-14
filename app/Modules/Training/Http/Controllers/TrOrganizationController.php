<?php

namespace App\Modules\Training\Http\Controllers;

use App\Libraries\ACL;
use yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Libraries\Encryption;
use App\Modules\Training\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Libraries\CommonFunction;

class TrOrganizationController extends Controller
{

    protected $aclName = 'Training';

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!ACL::getAccsessRight($this->aclName, '-V-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }
        return view('Training::organization.index');
    }
    public function getData()
    {
        if (!ACL::getAccsessRight($this->aclName, '-V-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }
        $organizationData = Organization::orderBy('id', 'DESC')->get();

        return Datatables::of($organizationData)
            ->editColumn('organization_name', function ($organization) {
                return $organization->organization_name;
            })
            ->editColumn('status', function ($organization) {
                $activate = $organization->is_active == 1 ? "btn-success" : "btn-danger";
                $status_name = $organization->is_active == 1 ? 'Active' : 'Inactive';
                return '<span class="btn-xs ' . $activate . '"><b>' . $status_name . '</b></span>';
            })
            ->addColumn('action', function ($organization) {

                $button = '<a href="' . url('/training/organization/edit-data/' . Encryption::encodeId($organization->id)) . '"  class="btn btn-xs btn-primary "><i class="fas fa-pencil-alt  p-1" style="font-size:12px;"></i> Edit </a> ';

                return $button;
            })
            ->rawColumns(['status', 'action'])
            ->removeColumn('id')
            ->make(true);
    }

    public function createData()
    {
        if (!ACL::getAccsessRight($this->aclName, '-A-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }
        return view('Training::organization.create');
    }

    public function storeData(Request $request)
    {
        if (!ACL::getAccsessRight($this->aclName, '-A-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }
        
        if($request->get('app_id')){
            $rules['organization_name'] = 'required|unique:organization_infos,organization_name,'.Encryption::decodeId($request->get('app_id'));
        }
        else{
            $rules['organization_name'] = 'required|unique:organization_infos,organization_name';
        }

        $messages = [
            'is_active.required' => 'Status is required',
            'organization_name.required' => 'Organization name is required',
            'organization_name.unique' => 'Organization name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->get('app_id')) {
                $appId = Encryption::decodeId($request->get('app_id'));
                $organization = Organization::find($appId);
                $msg = 'Organization updated successfully';
            } else {
                $organization = new Organization();
                $msg = 'Organization created successfully';
            }
            $organization->organization_name = $request->organization_name;
            $organization->is_active = $request->is_active;
            $organization->save();

            return redirect('training/organization/all-list')->with('success', $msg);

        } catch (\Exception $e) {
            Log::error('Organization : ' . $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine() . ' [TRS-73]');
            return response()->json([
                'responseCode' => 1,
                'html' => "<attachment_typeh4 class='custom-err-msg'>" . CommonFunction::showErrorPublic($e->getMessage()) . ' [TRC-90]' . "</attachment_typeh4>"
            ]);
        }
        
    }

    public function editData($id){
        if (!ACL::getAccsessRight($this->aclName, '-E-')) {
            return response()->json([
                'responseCode' => 1,
                'html' => "<h4 class='custom-err-msg'>You have no access right! Please contact system administration for more information</h4>"
            ]);
        }

        $organization_data = Organization::find(Encryption::decodeId($id));
        return view('Training::organization.edit', compact('organization_data', 'id'));
    }
}
