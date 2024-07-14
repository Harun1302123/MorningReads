<?php

namespace App\Modules\ProcessPath\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Libraries\ACL;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Libraries\UtilFunction;
use App\Modules\ProcessPath\Models\HelpText;
use App\Modules\ProcessPath\Models\ProcessDoc;
use App\Modules\ProcessPath\Models\ProcessFavoriteList;
use App\Modules\ProcessPath\Models\ProcessHistory;
use App\Modules\ProcessPath\Models\ProcessList;
use App\Modules\ProcessPath\Models\ProcessPath;
use App\Modules\ProcessPath\Models\ProcessStatus;
use App\Modules\ProcessPath\Models\ProcessType;
use App\Modules\Settings\Models\Configuration;
use App\Modules\Settings\Models\ShadowFile;
use App\Modules\Users\Models\Users;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use yajra\Datatables\Datatables;

class ProcessPathController extends Controller
{
    public $processPathTable = 'process_path';
    public $deskTable = 'user_desk';
    public $processStatus = 'process_status';
    protected $aclName;

    public function __construct()
    {
        $this->aclName = 'processPath';
    }

    public function processListById(Request $request, $id = '', $processStatus = '')
    {
        $userType = Auth::user()->user_type;
        if (CommonFunction::checkEligibility() != 1 and $userType == '5x505') {
            Session::flash('error', 'You are not eligible for apply ! [PPC-1042]');
            return redirect('dashboard');
        }

        try {
            if ($userType == '4x404') {
                Session::forget('is_delegation');
                Session::forget('batch_process_id');
                Session::forget('is_batch_update');
                Session::forget('single_process_id_encrypt');
                Session::forget('next_app_info');
                Session::forget('total_selected_app');
                Session::forget('total_process_app');
            }
            //end
            $process_type_id = $id != '' ? Encryption::decodeId($id) : 0;

            if (!session()->has('active_process_list')) {
                session()->put('active_process_list', $process_type_id);
            }


            $ProcessType = ProcessType::select(
                DB::raw("CONCAT(name_bn,' ',group_name) AS name"),
                'id'
            )
                ->whereStatus(1)
                ->where(function ($query) use ($userType) {
                    $query->where('active_menu_for', 'like', "%$userType%");
                })
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
            $process_info = ProcessType::where('id', $process_type_id)->first(['id', 'acl_name', 'form_url', 'name']);
            $processStatus = null;
            $status = ['' => 'Select one'] + ProcessStatus::where('process_type_id', $process_type_id != 0 ? $process_type_id : -1) // -1 means this service not available
                ->where('id', '!=', -1)
                    ->where('status', 1)
                    ->orderBy('status_name', 'ASC')
                    ->pluck('status_name', 'id')->toArray();
            $searchTimeLine = [
                '' => 'select One',
                '1' => '1 Day',
                '7' => '1 Week',
                '15' => '2 Weeks',
                '30' => '1 Month',
            ];
            $aclName = $this->aclName;

            // Global search or dashboard search option
            $search_by_keyword = '';
            if ($request->isMethod('post')) {
                $search_by_keyword = $request->get('search_by_keyword');
            }

            $number_of_rows = Configuration::where('caption', 'PROCESS_ROW_NUMBER')->value('value');

            $status_wise_apps = null;
            if ($userType == "1x101" || $userType == "4x404") {
                $status_wise_apps = ProcessList::statuswiseAppInDesks($process_type_id);
            }

            return view("ProcessPath::common-list", compact(
                'status',
                'ProcessType',
                'processStatus',
                'searchTimeLine',
                'process_type_id',
                'process_info',
                'aclName',
                'search_by_keyword',
                'status_wise_apps',
                'number_of_rows'
            ));
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1044]');
            return redirect()->back();
        }
    }

    public function setProcessType(Request $request)  //The function not use for now. ajax set process type
    {
        session()->put('active_process_list', $request->get('data'));
        return 'success';
    }

    public function searchProcessType(Request $request)  //ajax get process type
    {
        $process_type_id = $request->get('data');
        $status =  ProcessStatus::where('process_type_id', $process_type_id != 0 ? $process_type_id : -1) // -1 means this service not available
        ->whereNotIn('id', [-1, 3])
            ->orderBy('status_name')
            ->select(DB::raw("CONCAT(id,' ') AS id"), 'status_name')
            ->pluck('status_name', 'id')->all();

        $data = ['responseCode' => 1, 'data' => $status];
        return response()->json($data);
    }

    public function getList(Request $request, $status = '', $desk = '')
    {
        try {
            //        $process_type_id = session('active_process_list');
            $process_type_id = $request->get('process_type_id'); //new process type get by javascript
            $status == '-1000' ? '' : $status;
            $get_user_desk_ids = CommonFunction::getUserDeskIds();

            $prefix = '';
            if (CommonFunction::getUserType() == '5x505') {
                $prefix = 'client';
            }

            $user_id = CommonFunction::getUserId();
            $list = ProcessList::getApplicationList($process_type_id, $status, $request, $desk);

            /*
             * If search option has only one result then open the application
             */
            if ($request->filled('process_search')) {
                $list_count = $list->get()->count();
                if ($list_count == 1) {
                    $single_data = $list->get();
                    return response()->json([
                        'responseType' => 'single',
                        'url' => url('' . $prefix . '/process/' . $single_data[0]->form_url . '/view/' . Encryption::encodeId($single_data[0]->ref_id) . '/' . Encryption::encodeId($single_data[0]->process_type_id))
                    ]);
                }
            }

            $class = $this->batchUpdateClass($request, $desk);
            return Datatables::of($list)
                ->addColumn('action', function ($list) use ($status, $request, $prefix, $desk, $class) {

                    if (
                        $list->locked_by > 0
                        && Carbon::createFromFormat('Y-m-d H:i:s', $list->locked_at)->diffInMinutes() < 3 and $list->locked_by != Auth::user()->id
                    ) {
                        $locked_by_user = Users::where('id', $list->locked_by)
                            ->select(DB::raw("CONCAT_WS(' ', users.user_first_name, users.user_middle_name, users.user_last_name) as user_name"))
                            ->value('user_name');
                        $html = '<img width="20" src="' . url('/assets/images/Lock-icon_2.png') . '"/>' .
                            '<a onclick="return confirm(' . "'The record locked by $locked_by_user, would you like to force unlock?'" . ')"
                            target="_blank" href="' . url('process/' . $list->form_url . '/view/' . Encryption::encodeId($list->ref_id) . '/' . Encryption::encodeId($list->process_type_id)) . '"
                            class="btn btn-xs btn-primary"> Open</a> &nbsp;';
                    } else {
                        if (in_array($list->status_id, [-1, 5]) && $list->created_by == Auth::user()->id) {
                            $html = '<a class="subSectorEditBtn btn btn-xs btn-info"  href="' . url('' . $prefix . '/process/' . $list->form_url . '/edit/' . Encryption::encodeId($list->ref_id) . '/' . Encryption::encodeId($list->process_type_id)) . '" class="btn btn-xs btn-success button-color ' . $class['button_class'] . ' " style="color: white"> <i class="fa fa-edit"></i> Edit</a><br>';
                        } else {
                            $html = '<a class="subSectorEditBtn btn btn-xs btn-info"  href="' . url('' . $prefix . '/process/' . $list->form_url . '/view/' . Encryption::encodeId($list->ref_id) . '/' . Encryption::encodeId($list->process_type_id)) . '" class="btn btn-xs btn-primary button-color ' .  $class['button_class'] . ' " style="color: white"> <i class="fa fa-folder-open"></i> Open</a><br>';
                        }
                    }

                    $html .= '<input type="hidden" class="' . $class['input_class'] . '" name="batch_input"  value=' . Encryption::encodeId($list->id) . '>';
                    return $html;
                })
                ->editColumn('tracking_no', function ($list) use ($desk, $request, $class) {
                    $existingFavoriteItem = CommonFunction::checkFavoriteItem($list->id);
                    $htm = '';
                    if ($existingFavoriteItem > 0) {
                        $htm .= '<i style="cursor: pointer;color:#f0ad4e" class="fas fa-star remove_favorite_process" title="Added to your favorite list. Click to remove." id=' . Encryption::encodeId($list->id) . '></i> ' . $list->tracking_no;
                    } else {
                        $htm .= '<i style="cursor: pointer" class="far fa-star favorite_process"  title="Add to your favorite list" id=' . Encryption::encodeId($list->id) . '></i> ' . $list->tracking_no;
                    }
                    return $htm;
                })
                ->editColumn('json_object', function ($list) {
                    return getDataFromJson($list->json_object);
                })
                ->editColumn('process_status.status_name', function ($list) {
                    return $list->status_name;
                })
                ->editColumn('user_desk.desk_name', function ($list) {
                    return $list->desk_id == 0 ? 'Applicant' : $list->desk_name;
                })
                ->editColumn('updated_at', function ($list) {
                    return CommonFunction::updatedOn($list->updated_at);
                })
                ->removeColumn('id', 'ref_id', 'process_type_id', 'updated_by', 'closed_by', 'created_by', 'updated_by', 'desk_id', 'status_id', 'locked_by', 'ref_fields')
                ->rawColumns(['tracking_no', 'action'])
                ->setRowAttr([
                    'style' => function ($list) {
                        $color = '';
                        if ($list->priority == 1) {
                            $color .= '';
                        } elseif ($list->priority == 2) {
                            $color .= '    background: -webkit-linear-gradient(left, rgba(220,251,199,1) 0%, rgba(220,251,199,1) 80%, rgba(255,255,255,1) 100%);';
                        } elseif ($list->priority == 3) {
                            $color .= '    background: -webkit-linear-gradient(left, rgba(255,251,199,1) 0%, rgba(255,251,199,1) 40%, rgba(255,251,199,1) 80%, rgba(255,255,255,1) 100%);';
                        }
                        return $color;
                    },
                    'class' => function ($list) use ($get_user_desk_ids, $user_id) {
                        if (!in_array($list->status_id, [-1, 5, 6, 25]) && $list->read_status == 0 && in_array($list->desk_id, $get_user_desk_ids)) {
                            return 'unreadMessage';
                        } elseif (in_array($list->status_id, [5, 6, 25]) && $list->read_status == 0 && $list->created_by == $user_id) {
                            return 'unreadMessage';
                        }
                    }
                ])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1041]');
            return redirect()->back();
        }
    }

    public function getDeskByStatus(Request $request)
    {
        try {
            $process_list_id = Encryption::decodeId($request->get('process_list_id'));
            $status_from = Encryption::decodeId($request->get('status_from'));
            $cat_id = Encryption::decodeId($request->get('cat_id'));
            $statusId = trim($request->get('statusId'));


            $processInfo = ProcessList::where('id', $process_list_id)->first([
                'process_type_id', 'desk_id', 'ref_id'
            ]);

            $get_desk_list_query = "SELECT DGN.id, DGN.desk_name
                        FROM user_desk DGN WHERE
                        find_in_set(DGN.id,
                        (SELECT desk_to FROM process_path APP
                         where APP.desk_from LIKE '%$processInfo->desk_id%'
                            AND APP.status_from = '$status_from'
                            AND APP.cat_id = '$cat_id'
                            AND APP.process_type_id = '$processInfo->process_type_id'
                            AND APP.status_to REGEXP '^([0-9]*[,]+)*$statusId([,]+[,0-9]*)*$')) ";
            $deskList = DB::select($get_desk_list_query);

            $get_process_path_query = "SELECT APP.id, APP.ext_sql1, APP.file_attachment,APP.remarks
                            FROM process_path APP
                            WHERE APP.desk_from LIKE '%$processInfo->desk_id%'
                            AND APP.status_from = '$status_from'
                            AND APP.process_type_id = '$processInfo->process_type_id'
                            AND APP.cat_id = '$cat_id'
                            AND APP.status_to REGEXP '^([0-9]*[,]+)*$statusId([,]+[,0-9]*)*$' limit 1";
            $process_path_info = DB::select($get_process_path_query);

            // extra sql code here
            if ($process_path_info && isset($process_path_info[0]->ext_sql1)) { // ext_sql1 not null
                $fullSql = $process_path_info[0]->ext_sql1 . $processInfo->ref_id; // concat app id
                $ext_sql_desk_list = DB::select($fullSql);

                if ($ext_sql_desk_list[0]->returnStatus == 1) { // type_of_company = 1 and pr_cer_uplodead = no
                    $deskList = $ext_sql_desk_list; // assign new desk list from new query
                    if ($deskList[0]->id == null) { // desk = null or no desk
                        $deskList = [];
                    }
                } elseif ($ext_sql_desk_list[0]->returnStatus == -100) { // continue the previous query
                    $deskList = $deskList;
                }
            }
            // End extra sql code here


            // Generate desk list
            $final_desk_list = array();
            foreach ($deskList as $k => $v) {
                $tmpDeskId = $v->id;
                $final_desk_list[$tmpDeskId] = $v->desk_name;
            }
            // End Generate desk list

            // Send PIN number for final status
            $pinNumber = '';
            $processTypeFinalStatus = ProcessType::where('id', $processInfo->process_type_id)->first(['final_status']);
            $finalStatus = explode(",", $processTypeFinalStatus->final_status);
            if (in_array($statusId, $finalStatus)) {  //checking final status
                $result = CommonFunction::requestPinNumber($processInfo->ref_id, $processInfo->process_type_id);
                if ($result == true)
                    $pinNumber = 1;
            }
            // End Send PIN number for final status


            // Get Add-on form if have any
            $add_on_form = $this->requestFormContent($statusId, $processInfo->process_type_id, $processInfo->ref_id);
            // End Get Add-on form if have any

            $data = [
                'responseCode' => 1,
                'data' => $final_desk_list,
                'html' => $add_on_form,
                'remarks' => $process_path_info[0]->remarks ?? '',
                'file_attachment' => $process_path_info[0]->file_attachment ?? '',
                'pin_number' => $pinNumber
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1040]');
            return redirect()->back();
        }
    }

    protected function getUserByDesk(Request $request)
    {
        try {
            $desk_to = trim($request->get('desk_to'));
            $statusId = trim($request->get('statusId'));
            $cat_id = Encryption::decodeId($request->get('cat_id'));
            $status_from = Encryption::decodeId($request->get('status_from'));
            $desk_from = Encryption::decodeId($request->get('desk_from'));
            $process_type_id = Encryption::decodeId($request->get('process_type_id'));
            $office_id = Encryption::decodeId($request->get('office_id'));

            $get_process_path_sql = "SELECT APP.id, APP.ext_sql, APP.ext_sql2
            FROM process_path APP WHERE APP.desk_from = '$desk_from'
            AND APP.status_from = '$status_from'
            AND APP.cat_id = '$cat_id'
            AND APP.process_type_id = '$process_type_id'
            AND APP.status_to LIKE '%$statusId%' limit 1";

            $get_process_path = DB::select($get_process_path_sql);

            if ($get_process_path[0]->ext_sql2 != null) { // ext_sql two not null

                $get_user_list_query = str_replace("{desk_to}", "$desk_to", $get_process_path[0]->ext_sql2);
            } else {

                $get_user_list_query = "SELECT id as user_id, concat_ws(' ', user_first_name, user_middle_name, user_last_name) as user_full_name
                from users
                WHERE is_approved = 1
                AND user_status='active'
                AND desk_id REGEXP '^([0-9]*[,]+)*$desk_to([,]+[,0-9]*)*$'
                AND office_ids REGEXP '^([0-9]*[,]+)*$office_id([,]+[,0-9]*)*$'";
            }
            $user_list = DB::select($get_user_list_query);
            $data = ['responseCode' => 1, 'data' => $user_list];
            return response()->json($data);
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1036]');
            return redirect()->back();
        }
    }

    public function requestFormContent($CurrentStatusId, $process_type_id, $ref_id)
    {
        try {
            $form_id = ProcessStatus::where('process_type_id', $process_type_id)->where('id', $CurrentStatusId)->value('form_id');

            if ($form_id == 'AddOnForm/desk_from') {
                $appInfo = ProcessList::leftJoin('space_allocation as apps', 'apps.id', '=', 'process_list.ref_id')
                    ->where('process_list.ref_id', $ref_id)
                    ->where('process_list.process_type_id', $process_type_id)
                    ->first([
                        'process_list.company_id',
                        'process_list.desk_id',
                        'process_list.office_id',
                        'process_list.tracking_no',
                        'process_list.status_id',
                        'process_list.locked_by',
                        'process_list.locked_at',
                        'apps.*',
                    ]);
                $public_html = strval(view("ProcessPath::{$form_id}", compact('form_id', 'process_type_id', 'appInfo')));
            } elseif ($form_id == 'AddOnForm/general-desk-from') {
                $appInfo = ProcessList::leftJoin('ga_master as apps', 'apps.id', '=', 'process_list.ref_id')
                    ->where('process_list.ref_id', $ref_id)
                    ->where('process_list.process_type_id', $process_type_id)
                    ->first([
                        'process_list.company_id',
                        'process_list.desk_id',
                        'process_list.office_id',
                        'process_list.tracking_no',
                        'process_list.status_id',
                        'process_list.locked_by',
                        'process_list.locked_at',
                        'apps.service_name',
                    ]);

                $public_html = strval(view("ProcessPath::{$form_id}", compact('form_id', 'process_type_id', 'appInfo')));
            } elseif ($form_id == 'AddOnForm/process-certificate-form') {
                $public_html = strval(view("ProcessPath::{$form_id}", compact('form_id', 'process_type_id', 'appInfo')));
            } else {
                $public_html = '';
            }
            return $public_html;
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1032]');
            return redirect()->back();
        }
    }

    /*
     * Application Processing
     */
    public function updateProcess(Request $request)
    {
        $rules = [
            'status_id' => 'required',
        ];
        if ($request->get('is_remarks_required') == 1) {
            $rules['remarks'] = 'required';
        }
        if ($request->get('is_file_required') == 1) {
            $rules['attach_file'] = 'requiredarray';
        }

        //        if ($request->has('is_user')) {
        //            $rules['is_user'] = 'required|numeric';
        //        }

        if ($request->has('pin_number')) {
            if ($request->get('pin_number') == '') {
                Session::flash('error', "Pin number Field Is Required");
                return redirect()->back();
            }
        }
        $customMessages = [
            'status_id.required' => 'Apply Status Field Is Required',
            'remarks.required' => 'Remarks Field Is Required',
            'attach_file.requiredarray' => 'Attach File Field Is Required',
        ];
        $this->validate($request, $rules, $customMessages);

        try {

            //ob#code@start - (galib) This can be separated as a different method
            // if isset Application processing PIN number, then match the PIN
            if ($request->has('pin_number')) {
                $security_code = trim($request->get('pin_number'));
                $user_id = CommonFunction::getUserId();
                $count = Users::where('id', $user_id)->where(['pin_number' => $security_code])->count();
                if ($count <= 0) {
                    Session::flash('error', "Security Code doesn't match. [PPC-1030]");
                    return redirect()->back();
                }
            }
            // End if isset Application processing PIN number, then match the PIN
            //ob#code@end - (galib)

            //ob#code@start - (galib) can be in commonFunction
            if (empty(Auth::user()->signature_encode)) {
                Session::flash('error', "Please upload your signature before application processing. [PPC-1026]");
                return redirect()->back();
            }
            //ob#code@end - (galib)

            //ob#code@start - (galib) mixup of camel case and underscore in variable name
            $process_list_id = Encryption::decodeId($request->get('process_list_id'));
            $cat_id = Encryption::decodeId($request->get('cat_id'));
            $statusID = trim($request->get('status_id'));
            $deskID = (empty($request->get('desk_id')) ? 0 : trim($request->get('desk_id')));
            //ob#code@end - (galib)

            $existProcessInfo = ProcessList::where('id', $process_list_id)
                ->first([
                    'id',
                    'ref_id',
                    'tracking_no',
                    'office_id',
                    'process_type_id',
                    'status_id',
                    'desk_id',
                    'hash_value',
                    'user_id',
                    'created_by',
                    'locked_by'
                ]);

            //ob#code@start - (galib) can be separated
            /*
             * Verify Process Path
             * Check whether the application's process_type_id and cat_id and status_from
             * and desk_from and desk_to and status_to are equal with any of one row from process_path table
             */
            $process_path_count = DB::select("select count(*) as procss_path from process_path
                                        where process_type_id = $existProcessInfo->process_type_id
                                        AND cat_id = $cat_id
                                        AND status_from = $existProcessInfo->status_id
                                        AND desk_from = $existProcessInfo->desk_id
                                        AND desk_to = $deskID
                                        AND status_to REGEXP '^([0-9]*[,]+)*$statusID([,]+[,0-9]*)*$'");
            if ($process_path_count[0]->procss_path == 0) {
                Session::flash('error', 'Sorry, invalid process request.[PPC-1002]');
                return redirect('process/list/' . Encryption::encodeId($existProcessInfo->process_type_id));
            }
            /*
             * End Verify Process Path
             */
            //ob#code@end - (galib)

            //ob#code@start - (galib) can be separated
            // Desk user identify checking
            $user_id = 0;
            if (!empty($request->get('is_user'))) {
                $user_id = trim($request->get('is_user'));
                $findUser = Users::where('id', $user_id)->first();
                if (empty($findUser)) {
                    Session::flash('error', 'Desk user not found!.[PPC-1019]');
                    return Redirect::back()->withInput();
                }
            }
            // End Desk user identify checking
            //ob#code@end - (galib)

            // Process data verification, if verification is true then proceed for Processing
            $verificationData = [];
            $verificationData['id'] = $existProcessInfo->id;
            $verificationData['status_id'] = $existProcessInfo->status_id;
            $verificationData['desk_id'] = $existProcessInfo->desk_id;
            $verificationData['user_id'] = $existProcessInfo->user_id;
            $verificationData['office_id'] = $existProcessInfo->office_id;
            $verificationData['tracking_no'] = $existProcessInfo->tracking_no;
            $verificationData['created_by'] = $existProcessInfo->created_by;
            $verificationData['locked_by'] = $existProcessInfo->locked_by;
            $verificationData = (object)$verificationData;
            if (Encryption::decode($request->data_verification) == UtilFunction::processVerifyData($verificationData)) 
            {
                // On Behalf of desk id
                $on_behalf_of_user = 0;
                $my_desk_ids = CommonFunction::getUserDeskIds();
                if (!in_array($existProcessInfo->desk_id, $my_desk_ids)) {
                    $on_behalf_of_user = Encryption::decodeId($request->get('on_behalf_user_id'));
                }

                // Process attachment store
                if ($request->hasFile('attach_file')) {
                    $attach_file = $request->file('attach_file');
                    foreach ($attach_file as $afile) {
                        $original_file = $afile->getClientOriginalName();
                        $afile->move('uploads/', time() . $original_file);
                        $file = new ProcessDoc;
                        $file->process_type_id = $existProcessInfo->process_type_id;
                        $file->ref_id = $process_list_id;
                        $file->desk_id = $request->get('desk_id');
                        $file->status_id = $request->get('status_id');
                        $file->file = 'uploads/' . time() . $original_file;
                        $file->save();
                    }
                }
                // End Process attachment store

                // Updating process list
                $status_from = $existProcessInfo->status_id;
                $deskFrom = $existProcessInfo->desk_id;

                if (empty($deskID)) {
                    $whereCond = "select * from process_path
                                where process_type_id='$existProcessInfo->process_type_id'
                                AND status_from = '$status_from'
                                AND desk_from = '$deskFrom'
                                AND status_to REGEXP '^([0-9]*[,]+)*$statusID([,]+[,0-9]*)*$'";
                    $processPath = DB::select($whereCond);

                    $deskList = null;
                    // if ext_sql not null
                    if (count($processPath) > 0 && $processPath[0]->ext_sql1 != "NULL" && $processPath[0]->ext_sql1 != "") {
                        $fullSql = $processPath[0]->ext_sql . $existProcessInfo->ref_id; // concat app id
                        $ext_sql_desk_list = DB::select($fullSql);
                        if ($ext_sql_desk_list[0]->returnStatus == 1) {
                            $deskList = $ext_sql_desk_list; // assign new desk list from new query
                        }
                    }
                    if (!empty($deskList[0]->deskIsnull) && $deskList[0]->deskIsnull != -100) {
                        $deskID = $deskList[0]->deskIsnull;
                    } else {
                        $deskID = 0;
                        $user_id = 0;
                        if (count($processPath) > 0 && $processPath[0]->desk_to == '0')  // Sent to Applicant
                            $deskID = 0;
                        if (count($processPath) > 0 && $processPath[0]->desk_to == '-1') {  // Keep in same desk
                            $deskID = $deskFrom;
                            $user_id = CommonFunction::getUserId(); //user wise application assign
                        }
                    }
                }

                // Process data for modification
                $processData['desk_id'] = $deskID;
                $processData['status_id'] = $statusID;
                $processData['process_desc'] = $request->get('remarks');
                $processData['user_id'] = $user_id;
                $processData['on_behalf_of_user'] = $on_behalf_of_user;
                $processData['updated_by'] = Auth::user()->id;
                $processData['locked_by'] = 0;
                $processData['locked_at'] = null;
                $processData['read_status'] = 0;

                $processTypeFinalStatus = ProcessType::where('id', $existProcessInfo->process_type_id)->first(['final_status']);
                $finalStatus = explode(",", $processTypeFinalStatus->final_status);
                $closed_by = 0;
                if (in_array($statusID, $finalStatus)) {
                    $closed_by = CommonFunction::getUserId();
                }
                $processData['closed_by'] = $closed_by;

                /*
                 * Process Hash value generate
                 */


                $resultData = $existProcessInfo->id . '-' . $existProcessInfo->tracking_no .
                    $deskID . '-' . $statusID . '-' . $processData['user_id'] . '-' .
                    $processData['updated_by'];

                $processData['previous_hash'] = $existProcessInfo->hash_value;
                $processData['hash_value'] = Encryption::encode($resultData);
                /*
                 * End Process Hash value generate
                 */

                DB::beginTransaction();
                ProcessList::where('id', $existProcessInfo->id)->update($processData);
                
                /*
                 * process type wise, process status wise additional info update
                 * application certificate generation, email or sms sending function,
                 * During the processing of the application, the data provided by the desk user in the add-on form is given
                 * CertificateMailOtherData() comes from app\Modules\ProcessPath\helper.php
                 */
                //ob#code@start - (galib) can be separated
                $result = CertificateMailOtherData($existProcessInfo->id, $statusID, $request->all(), $existProcessInfo->desk_id);
                //ob#code@end - (galib)
                if ($result == false) {
                    DB::rollback();
                    Session::flash('error', 'Sorry! Something is Wrong. [PPC-1003]');
                    return Redirect::back()->withInput();
                }

                DB::commit();

                //ob#code@start - (galib) can be separated
                // new code for batch update
                if (isset($request->is_batch_update)) {
                    $batch_process_id = Session::get('batch_process_id');

                    $single_process_id_encrypt_next = null;
                    $single_process_id_encrypt_second_next_key = null;
                    $find_current_key = array_search($request->get('single_process_id_encrypt'), $batch_process_id); //find current key
                    $keys = array_keys($batch_process_id); //total key
                    $nextKey = isset($keys[array_search($find_current_key, $keys) + 1]) ? $keys[array_search($find_current_key, $keys) + 1] : ''; //next key
                    $second_nextKey = isset($keys[array_search($find_current_key, $keys) + 2]) ? $keys[array_search($find_current_key, $keys) + 2] : ''; //second next key

                    if (!empty($nextKey)) {
                        $single_process_id_encrypt_next = $batch_process_id[$nextKey]; //next process id
                    }
                    if (!empty($second_nextKey)) {
                        $single_process_id_encrypt_second_next_key = $batch_process_id[$second_nextKey]; //next second process id
                    }

                    if (empty($single_process_id_encrypt_next)) {
                        Session::flash('success', 'Process has been updated successfully.');
                        return redirect('process/list/' . Encryption::encodeId($existProcessInfo->process_type_id));
                    }

                    Session::put('single_process_id_encrypt', $single_process_id_encrypt_next);
                    $nextAppInfo = 'null';
                    if ($single_process_id_encrypt_second_next_key != null) {
                        $nextAppInfo = ProcessList::where('process_list.id', Encryption::decodeId($single_process_id_encrypt_second_next_key))->first(['tracking_no'])->tracking_no;
                    }
                    Session::put('next_app_info', $nextAppInfo);
                    $get_total_process_app = Session::get('total_process_app');
                    Session::put('total_process_app', $get_total_process_app + 1);

                    $processData = ProcessList::leftJoin('process_type', 'process_list.process_type_id', '=', 'process_type.id')
                        ->where('process_list.id', Encryption::decodeId($single_process_id_encrypt_next))->first(['process_type.form_url', 'process_list.ref_id', 'process_list.process_type_id']);
                    Session::flash('success', 'Process has been updated successfully.');
                    $redirectUrl = 'process/' . $processData->form_url . '/view/' . Encryption::encodeId($processData->ref_id) . '/' . Encryption::encodeId($processData->process_type_id);
                    return redirect($redirectUrl);
                }
                //end


            } else {
                Session::flash('error', 'Sorry, Process data verification failed. [PPC-1003]');
            }
            //ob#code@end - (galib)
            return redirect('process/list/' . Encryption::encodeId($existProcessInfo->process_type_id));
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'Sorry, something went wrong. ' . CommonFunction::showErrorPublic($e->getMessage()) . '[PPC-1004]');
            return redirect()->back();
        }
    }

    /**
     * Check application validity for application process
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkApplicationValidity(Request $request)
    {
        $process_list_id = Encryption::decodeId($request->get('process_list_id'));

        /*
         * $existProcessInfo variable must should be same as $verificationData variable
         * of applicationOpen() function, it's required for application verification
         *
         *
         * When one officer is processing an application, another officer may want to open the application.
         * If the 2nd officer forcibly opens the application, the previous officer should be alerted,
         * this is done through process data verification. That's why the 'locked_by' field is a must.
         */
        $existProcessInfo = ProcessList::where('id', $process_list_id)
            ->first([
                'id',
                'status_id',
                'desk_id',
                'user_id',
                'office_id',
                'tracking_no',
                'created_by',
                'locked_by'
            ]);


        if (Encryption::decode($request->data_verification) == UtilFunction::processVerifyData($existProcessInfo)) {
            return response()->json(array('responseCode' => 1));
        }
        return response()->json(array('responseCode' => 0));
    }


    /**
     * Load status list
     * @param $param
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxRequest($param, Request $request)
    {
        try {
            $data = ['responseCode' => 0];
            $cat_id = Encryption::decodeId($request->get('cat_id'));
            $process_list_id = Encryption::decodeId($request->get('process_list_id'));
            $appInfo = ProcessList::where('id', $process_list_id)->first(
                [
                    'process_type_id',
                    'id as process_list_id',
                    'status_id',
                    'ref_id',
                    'id',
                    'json_object',
                    'desk_id',
                    'process_desc',
                    'updated_at'
                ]
            );
            $statusFrom = $appInfo->status_id; // current process status
            $deskId = $appInfo->desk_id; // Current desk id
            $process_type_id = $appInfo->process_type_id; // Current desk id

            if ($param == 'load-status-list') {

                // Get extra SQL from this process path for Status loading,
                // if have any extra sql then , load status list from extra SQL
                // otherwise status list load from Static Query
                $check_extra_sql = ProcessPath::where(['status_from' => $statusFrom, 'desk_from' => $deskId, 'process_type_id' => $process_type_id, 'cat_id' => $cat_id])
                    ->first(['id', 'ext_sql']);
                if (!empty($check_extra_sql->ext_sql)) {
                    $get_status_query = str_replace("{app_id}", "$appInfo->ref_id", $check_extra_sql->ext_sql);
                } else {
                    $get_status_query = "SELECT APS.id, APS.status_name
                        FROM process_status APS
                        WHERE find_in_set(APS.id,
                        (SELECT GROUP_CONCAT(status_to) FROM process_path APP
                        WHERE APP.status_from = '$statusFrom'
                        AND APP.desk_from = '$deskId'
                        AND APP.cat_id = '$cat_id'
                        AND APP.process_type_id = '$process_type_id'))
                        AND APS.process_type_id = '$process_type_id'
                        order by APS.status_name";
                }
                $status_list = DB::select($get_status_query);

                // Get suggested desk
                $suggested_status = $this->getSuggestedStatus($appInfo, $cat_id);

                $data = ['responseCode' => 1, 'data' => $status_list, 'suggested_status' => $suggested_status];
            }
            return response()->json($data);
        } catch (Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . "[PPC-1021]");
            return Redirect::back();
        }
    }

    public function getSuggestedStatus($appInfo, $cat_id)
    {
        try {
            // Get suggested status by comment
            $suggested_status_by_comment = 0;
            $suggested_status_data = ProcessType::where('id', $appInfo->process_type_id)->first(['suggested_status_json']);

            if (!empty($suggested_status_data->suggested_status_json)) {
                $suggested_status_json = json_decode($suggested_status_data->suggested_status_json);
                if (!empty($suggested_status_json)) {
                    foreach ($suggested_status_json as $json) {
                        $search_result = strpos($appInfo->process_desc, $json->comments);
                        if ($search_result !== false) {
                            $suggested_status_by_comment = $json->status;
                            break;
                        }
                    }
                }
            }
            if (!empty($suggested_status_by_comment)) {
                return $suggested_status_by_comment;
            }

            // Get suggested status by process path
            $suggested_status_data = ProcessPath::where([
                'process_type_id' => $appInfo->process_type_id,
                'cat_id' => $cat_id,
                'desk_from' => $appInfo->desk_id,
                'status_from' => $appInfo->status_id,
            ])->where('suggested_status', '!=', 0)->first(['suggested_status']);

            return empty($suggested_status_data->suggested_status) ? 0 : $suggested_status_data->suggested_status;
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1017]');
            return redirect()->back();
        }
    }


    public function applicationAdd($module = '', $encoded_process_type_id)
    {
        try {
            $mode = '-A-';
            $viewMode = 'off';
            $openMode = 'add';
            $decoded_process_type_id = Encryption::decodeId($encoded_process_type_id);
            $process_info = ProcessType::where('id', $decoded_process_type_id)->first([
                'id as process_type_id',
                'acl_name',
                'form_id',
                'name'
            ]);
            $form_id = json_decode($process_info->form_id, true);
            $url = (isset($form_id[$openMode]) ? $form_id[$openMode] : '');
            $page_header = $process_info->name;

            // Following variables will be used for Ajax calling from the form page
            $encoded_app_id = 0;
            $encoded_process_list_id = 0;
            return view(
                "ProcessPath::form",
                compact('process_info', 'mode', 'viewMode', 'openMode', 'url', 'page_header', 'encoded_app_id', 'encoded_process_type_id', 'encoded_process_list_id')
            );
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . ' [PPC-1008]');
            return Redirect::back();
        }
    }

    public function applicationOpen($module = '', $encoded_app_id, $encoded_process_type_id)
    {
        try {
            $process_type_id = Encryption::decodeId($encoded_process_type_id);
            $application_id = Encryption::decodeId($encoded_app_id);
            $user_type = CommonFunction::getUserType();

            $process_info = ProcessList::leftJoin('process_type', 'process_type.id', '=', 'process_list.process_type_id')
                ->leftJoin('process_status as ps', function ($join) use ($process_type_id) {
                    $join->on('ps.id', '=', 'process_list.status_id');
                    $join->on('ps.process_type_id', '=', DB::raw($process_type_id));
                })
                ->leftJoin('pdf_print_requests_queue as pdf', function ($join) use ($process_type_id) {
                    $join->on('pdf.app_id', '=', 'process_list.ref_id');
                    $join->on('pdf.process_type_id', '=', DB::raw($process_type_id));
                })
                ->leftJoin('user_desk', 'user_desk.id', '=', 'process_list.desk_id')
                ->where([
                    'process_list.ref_id' => $application_id,
                    'process_list.process_type_id' => $process_type_id,
                ])->first([
                    'process_list.id as process_list_id',
                    'process_list.desk_id',
                    'process_list.office_id',
                    'process_list.cat_id',
                    'process_list.process_type_id',
                    'process_list.status_id',
                    'process_list.locked_by',
                    'process_list.locked_at',
                    'process_list.ref_id',
                    'process_list.tracking_no',
                    'process_list.company_id',
                    'process_list.process_desc',
                    'process_list.priority',
                    'process_list.json_object',
                    'process_list.updated_at',
                    'process_list.created_by',
                    'process_list.user_id',
                    'process_list.read_status',
                    'process_list.submitted_at',
                    'process_type.name',
                    'process_type.acl_name',
                    'process_type.form_id',
                    'ps.status_name',
                    'pdf.certificate_link',
                    'user_desk.desk_name',
                ]);

            if (empty($process_info)) {
                Session::flash('error', 'Invalid application [PPC-1096]');
                return \redirect()->back();
            }

            // Following variables will be used for Ajax calling from the form page
            $encoded_process_list_id = Encryption::encodeId($process_info->process_list_id);
            $page_header = $process_info->name;

            // ViewMode, EditMode permission setting
            $viewMode = 'on';
            $openMode = 'view';
            $mode = '-V-';

            $form_id = json_decode($process_info->form_id, true);
            $url = (isset($form_id[$openMode]) ? $form_id[$openMode] : '');

            // Update process read status from applicant user
            if ($process_info->created_by == Auth::user()->id && in_array($process_info->status_id, [5, 6, 25]) && $process_info->read_status == 0) {
                $this->updateProcessReadStatus($application_id);
            }


            /**
             * if this user has access to application processing,
             * then check the permission for this application with the corresponding desk, office etc.
             */
            $accessMode = ACL::getAccsessRight($process_info->acl_name);
            $hasDeskOfficeWisePermission = false;
            if (ACL::isAllowed($accessMode, '-UP-')) {
                $hasDeskOfficeWisePermission = CommonFunction::hasDeskOfficeWisePermission($process_info->desk_id, $process_info->office_id);

                // Update process read status from desk officer user
                if (($hasDeskOfficeWisePermission && $process_info->read_status == 0)) {
                    $this->updateProcessReadStatus($application_id);
                }

                if ($hasDeskOfficeWisePermission) {
                    $remarks_attachment = DB::select(
                        "select * from
                        `process_documents`
                        where `process_type_id` = $process_info->process_type_id and `ref_id` = $process_info->process_list_id and `status_id` = $process_info->status_id
                        and `process_hist_id` = (SELECT MAX(process_hist_id) FROM process_documents WHERE ref_id=$process_info->process_list_id AND process_type_id=$process_info->process_type_id AND status_id=$process_info->status_id)
                        ORDER BY id ASC"
                    );
                }
            }


            /*
             * Conditional data for desk user, system admin
             */
            $verificationData = [];
            $cat_id = '';
            $remarks_attachment = '';
            if (in_array($user_type, ['4x404', '3x303', '1x101'])) {

                $cat_id = $process_info->cat_id;

                /**
                 * Lock application by the current user,
                 * if the current user's desk id is not equal to zero (0) and
                 * application desk id is in user's authorized desk
                 */
                $userDeskIds = CommonFunction::getUserDeskIds();

                if (Auth::user()->desk_id != 0 && (in_array($process_info->desk_id, $userDeskIds) || in_array($process_info->desk_id, $this->getDelegateUsers()))) {
                    ProcessList::where('id', $process_info->process_list_id)->update([
                        'locked_by' => Auth::user()->id,
                        'locked_at' => date('Y-m-d H:i:s')
                    ]);
                }
                // End Lock application by current desk user


                /*
                * $verificationData variable must should be same as $existProcessInfo variable
                * of checkApplicationValidity() function, it's required for application verification
                */

                $verificationData['id'] = $process_info->process_list_id;
                $verificationData['status_id'] = $process_info->status_id;
                $verificationData['desk_id'] = $process_info->desk_id;
                $verificationData['user_id'] = $process_info->user_id;
                $verificationData['office_id'] = $process_info->office_id;
                $verificationData['tracking_no'] = $process_info->tracking_no;
                $verificationData['created_by'] = $process_info->created_by;

                /*
                * When one officer is processing an application, another officer may want to open the application.
                * If the 2nd officer forcibly opens the application, the previous officer should be alerted,
                * this is done through process data verification. That's why the 'locked_by' field is a must.
                *
                * Locked by field updates when the application is open. Since the database will not be updated
                * before the transaction is completed, we will give the value directly.
                */
                $verificationData['locked_by'] = Auth::user()->id;
                $verificationData = (object)$verificationData;
            }

            return view("ProcessPath::form", compact(
                'url',
                'process_info',
                'encoded_app_id',
                'mode',
                'viewMode',
                'encoded_process_type_id',
                'encoded_process_list_id',
                'openMode',
                'verificationData',
                'hasDeskOfficeWisePermission',
                'page_header',
                'cat_id',
                'remarks_attachment'
            ));
        } catch (\Exception $e) {
            Session::flash('error', 'Something went wrong!. ' . CommonFunction::showErrorPublic($e->getMessage()) . '[PPC-109]');
            return \redirect()->back();
        }
    }

    public function applicationEdit($module = '', $encoded_app_id, $encoded_process_type_id)
    {

        try {
            $verificationData = [];
            $cat_id = '';
            $remarks_attachment = '';

            $process_type_id = Encryption::decodeId($encoded_process_type_id);
            $application_id = Encryption::decodeId($encoded_app_id);

            $process_info = ProcessList::leftJoin('process_type', 'process_type.id', '=', 'process_list.process_type_id')
                ->leftJoin('process_status as ps', function ($join) use ($process_type_id) {
                    $join->on('ps.id', '=', 'process_list.status_id');
                    $join->on('ps.process_type_id', '=', DB::raw($process_type_id));
                })
                ->leftJoin('pdf_print_requests_queue as pdf', function ($join) use ($process_type_id) {
                    $join->on('pdf.app_id', '=', 'process_list.ref_id');
                    $join->on('pdf.process_type_id', '=', DB::raw($process_type_id));
                })
                ->where([
                    'process_list.ref_id' => $application_id,
                    'process_list.process_type_id' => $process_type_id,
                ])->first([
                    'process_list.id as process_list_id',
                    'process_list.desk_id',
                    'process_list.office_id',
                    'process_list.cat_id',
                    'process_list.process_type_id',
                    'process_list.status_id',
                    'process_list.locked_by',
                    'process_list.locked_at',
                    'process_list.ref_id',
                    'process_list.tracking_no',
                    'process_list.company_id',
                    'process_list.process_desc',
                    'process_list.priority',
                    'process_list.json_object',
                    'process_list.updated_at',
                    'process_list.created_by',
                    'process_list.user_id',
                    'process_type.name',
                    'process_type.acl_name',
                    'process_type.form_id',
                    'pdf.certificate_link',
                    'ps.status_name',
                ]);

            if (empty($process_info)) {
                Session::flash('error', 'Invalid application [PPC-1096]');
                return \redirect()->back();
            }

            // Following variables will be used for Ajax calling from the form page
            $encoded_process_list_id = Encryption::encodeId($process_info->process_list_id);
            $page_header = $process_info->name;

            // ViewMode, EditMode permission setting
            $viewMode = 'on';
            $openMode = 'view';
            $mode = '-V-';
            $hasDeskOfficeWisePermission = false;
            $user_type = CommonFunction::getUserType();

            if (in_array($user_type, ['5x505', '6x606'])) {
                $companyId = CommonFunction::getUserCompanyWithZero();
                if ($process_info->company_id == $companyId && in_array($process_info->status_id, [-1, 5])) {
                    $mode = '-E-';
                    $viewMode = 'off';
                    $openMode = 'edit';
                }
            }



            // No need to check the acl again in application view function into corresponding controller
            if (!ACL::getAccsessRight($process_info->acl_name, $mode)) {
                die('You have no access right! Please contact system administration for more information.');
            }

            $form_id = json_decode($process_info->form_id, true);
            $url = (isset($form_id[$openMode]) ? $form_id[$openMode] : '');

            return view("ProcessPath::form", compact(
                'url',
                'process_info',
                'mode',
                'viewMode',
                'openMode',
                'hasDeskOfficeWisePermission',
                'verificationData',
                'page_header',
                'cat_id',
                'remarks_attachment',
                'encoded_process_type_id',
                'encoded_app_id',
                'encoded_process_list_id'
            ));
        } catch (Exception $exception) {
            Session::flash('error', 'Something went wrong! [PPC-1019]');
            return \redirect()->back();
        }
    }

    public function updateProcessReadStatus($application_id)
    {
        ProcessList::where('ref_id', $application_id)->update(['read_status' => 1]);
    }


    public function getHelpText(Request $request)
    {
        try {
            if ($request->has('uri') && $request->get('uri') != '') {
                $module = $request->get('uri');
            }

            if (!empty($module)) {
                $data = HelpText::where('is_active', 1)->where('module', $module)->get(['field_id', 'field_class', 'help_text', 'help_text_type', 'validation_class']);
            } else {
                $data = HelpText::where('is_active', 1)->get(['field_id', 'field_class', 'help_text', 'help_text_type']);
            }
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1017]');
            return redirect()->back();
        }
    }

    public function favoriteDataStore(Request $request)
    {
        $process_id = Encryption::decodeId($request->get('process_list_id'));
        ProcessFavoriteList::create([
            'process_id' => $process_id,
            'user_id' => CommonFunction::getUserId()
        ]);
        return response()->json('success');
    }

    public function favoriteDataRemove(Request $request)
    {
        $process_id = Encryption::decodeId($request->get('process_list_id'));
        ProcessFavoriteList::where('process_id', $process_id)
            ->where('user_id', CommonFunction::getUserId())
            ->delete();
        return response()->json('success');
    }

    public function getShadowFileHistory($process_type_id, $ref_id)
    {
        $process_type_id = Encryption::decodeId($process_type_id);
        $ref_id = Encryption::decodeId($ref_id);
        $getShadowFile = ShadowFile::where('user_id', CommonFunction::getUserId())
            ->where('ref_id', $ref_id)
            ->where('process_type_id', $process_type_id)
            ->orderBy('id', 'DESC')
            ->get();
        $content = strval(view('ProcessPath::shadow-file-history', compact('getShadowFile')));
        return response()->json(['response' => $content]);
    }

    public function getApplicationHistory($process_list_id)
    {
        try {
            $decoded_process_list_id = Encryption::decodeId($process_list_id);
            $process_history = DB::select("select  `process_list_hist`.`desk_id`,`as`.`status_name`,
                                `process_list_hist`.`process_id`,
                                if(`process_list_hist`.`desk_id`=0,\"-\",`ud`.`desk_name`) `deskname`,
                                `users`.`user_first_name`,
                                `users`.`user_middle_name`,
                                `users`.`user_last_name`,
                                `process_list_hist`.`updated_by`,
                                `process_list_hist`.`status_id`,
                                `process_list_hist`.`process_desc`,
                                `process_list_hist`.`process_id`,
                                `process_list_hist`.`updated_at`,
                                 group_concat(`pd`.`file`) as files
                                from `process_list_hist`
                                left join `process_documents` as `pd` on `process_list_hist`.`id` = `pd`.`process_hist_id`
                                left join `user_desk` as `ud` on `process_list_hist`.`desk_id` = `ud`.`id`
                                left join `users` on `process_list_hist`.`updated_by` = `users`.`id`

                                left join `process_status` as `as` on `process_list_hist`.`status_id` = `as`.`id`
                                and `process_list_hist`.`process_type_id` = `as`.`process_type_id`
                                where `process_list_hist`.`process_id`  = '$decoded_process_list_id'
                                and `process_list_hist`.`status_id` != -1
                    group by `process_list_hist`.`process_id`,`process_list_hist`.`desk_id`, `process_list_hist`.`status_id`, process_list_hist.updated_at
                    order by process_list_hist.updated_at desc
                    ");
            $content = strval(view('ProcessPath::application-history', compact('process_list_id', 'process_history')));
            return response()->json(['response' => $content]);
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1003]');
            return redirect()->back();
        }
    }


    public function getProcessData($processTypeId, $appId = 0, $cat_id)
    {
        try {
            $app_id = Encryption::decodeId($appId);
            $processTypeId = Encryption::decodeId($processTypeId);

            $resubmitId = ProcessHistory::where('ref_id', $app_id)
                ->where('process_type_id', $processTypeId)
                ->where('status_id', '=', 2)
                ->orderBy('id', 'desc')
                ->first(['id']);


            if ($resubmitId != null) {
                $sql2 = "SELECT  group_concat(distinct desk_id) as deskIds,group_concat(distinct status_id) as statusIds from process_list_hist
                where id >= $resubmitId->id and ref_id= $app_id
                and process_type_id=$processTypeId and status_id!='-1'";
                $processHistory = DB::select($sql2);
            } else {
                $sql = "select  group_concat(distinct desk_id) as deskIds,group_concat(distinct status_id) as statusIds,group_concat(distinct id) as history_id  from process_list_hist
                where ref_id = $app_id and process_type_id = $processTypeId and status_id!='-1'";
                $processHistory = DB::select($sql);
            }

            //extra code for dynamic graph
            $passed_desks_ids = explode(',', $processHistory[0]->deskIds);
            $passed_status_ids = explode(',', $processHistory[0]->statusIds);

            array_push($passed_desks_ids, 0);

            foreach ($passed_desks_ids as $v) {
                $passed_desks_id[] = (int)$v;
            }

            foreach ($passed_status_ids as $va) {
                $passed_status_id[] = (int)$va;
            }

            $passed_status_id = array_reverse($passed_status_id);
            //extra code for dynamic graph end

            $processPathTable = $this->processPathTable;
            $deskTable = $this->deskTable;
            $processStatus = $this->processStatus;

            $fullProcessPath = DB::table($processPathTable)
                ->leftJoin($deskTable . ' as from_desk', $processPathTable . '.desk_from', '=', 'from_desk.id')
                ->leftJoin($deskTable . ' as to_desk', $processPathTable . '.desk_to', '=', 'to_desk.id')
                ->leftJoin($processStatus . ' as from_process_status', function ($join) use ($processTypeId, $processPathTable) {
                    $join->where('from_process_status.process_type_id', '=', $processTypeId);
                    $join->on($processPathTable . '.status_from', '=', 'from_process_status.id');
                })
                ->leftJoin($processStatus . ' as to_process_status', function ($join) use ($processTypeId, $processPathTable) {
                    $join->where('to_process_status.process_type_id', '=', $processTypeId);
                    $join->on($processPathTable . '.status_to', '=', 'to_process_status.id');
                })
                ->select(
                    $processPathTable . '.desk_from',
                    $processPathTable . '.desk_to',
                    $processPathTable . '.status_from as status_from',
                    $processPathTable . '.status_to as status_to',
                    'from_desk.desk_name as from_desk_name',
                    'to_desk.desk_name as to_desk_name',
                    'from_process_status.status_name as from_status_name',
                    'to_process_status.status_name as to_status_name',
                    'to_process_status.id as status_id'
                )
                ->where($processPathTable . '.process_type_id', $processTypeId)
                ->where($processPathTable . '.cat_id', $cat_id)
                ->orderBy('process_path.id', 'ASC')
                ->get();

            $moveToNextPath = [];
            $deskActions = [];
            $i = 0;

            foreach ($fullProcessPath as $process) {

                if ($i == 0) {
                    $moveToNextPath[] = [
                        'Applicant',
                        $process->from_desk_name,
                        [
                            'label' => isset($resubmitId->id) ? 'Re-submitted' : $process->from_status_name,
                        ],
                    ];
                }

                if (intval($process->desk_to) > 0) {

                    $moveToNextPath[] = [
                        $process->from_desk_name,
                        $process->to_desk_name,
                        [
                            'label' => $process->to_status_name,
                        ],
                    ];
                } else {
                    $moveToNextPath[] = [
                        $process->from_desk_name,
                        $process->from_desk_name . '_' . $process->to_status_name,
                        ['label' => $process->to_status_name],
                    ];

                    $deskActions[] = [
                        'name' => $process->from_desk_name . '_' . $process->to_status_name,
                        'label' => $process->to_status_name,
                        'action_id' => $process->status_id,
                        'shape' => 'ellipse',
                        'background' => $this->getColor($process->status_to),
                    ];
                }

                $i++;
            }

            $allFromDeskForThisProcess = DB::table($processPathTable)
                ->select('from_desk.desk_name as name', 'from_desk.id as desk_id', DB::raw('CONCAT(from_desk.desk_name, " (", from_desk.id, ")") as label'))
                ->leftJoin($deskTable . ' as from_desk', $processPathTable . '.desk_from', '=', 'from_desk.id')
                ->where($processPathTable . '.process_type_id', $processTypeId)
                ->groupBy('desk_from')
                ->get()->toArray();

            array_push($allFromDeskForThisProcess, [
                'name' => 'Applicant',
                'label' => 'Applicant',
                'desk_id' => 0
            ]);

            return response()->json([
                'desks' => $allFromDeskForThisProcess,
                'desk_action' => $deskActions,
                'edge_path' => $moveToNextPath,
                'passed_desks_id' => $passed_desks_id,
                'passed_status_id' => $passed_status_id,
            ]);
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1013]');
            return redirect()->back();
        }
    }

    public function getColor($i)
    {
        //ob#code@start - (galib) this array can be set in configuration
        $colorArray = [
            '#800000',
            '#3cb44b',
            '#e6194b',
            '#911eb4',
            '#aa6e28',
            '#145A32',
            '#000080',
            '#000000',
            '#1B2631',
            '#1B4F72',
            '#008000',
            '#800080',
        ];
        try {
            return $colorArray[$i];
        } catch (\Exception $e) {

            return '#9d68d0';
        }
        //ob#code@end - (galib)
    }


    public function requestShadowFile(Request $request)
    {
        try {

            $jsonData['process_id'] = ($request->has('process_id') ? Encryption::decodeId($request->get('process_id')) : '');
            $jsonData['module_name'] = ($request->has('module_name') ? str_replace("", '', $request->get('module_name')) : '');
            $jsonData['process_type_id'] = ($request->has('process_type_id') ? Encryption::decodeId($request->get('process_type_id')) : '');
            $jsonData['app_id'] = ($request->has('ref_id') ? Encryption::decodeId($request->get('ref_id')) : '');
            $jsonInfo = json_encode($jsonData);

            ShadowFile::create([
                'file_path' => '',
                'user_id' => CommonFunction::getUserId(),
                'process_type_id' => $jsonData['process_type_id'],
                'ref_id' => $jsonData['app_id'],
                'shadow_file_perimeter' => $jsonInfo
            ]);

            return response()->json(['responseCode' => 1, 'status' => 'success']);
        } catch (Exception $e) {
            return response()->json(['responseCode' => 0, 'messages' => CommonFunction::showErrorPublic($e->getMessage())]);
        }
    }

    public function verifyProcessHistory($process_list_id)
    {
        try {
            $process_list_id = Encryption::decodeId($process_list_id);

            $process_history = DB::select("select  `process_list_hist`.`process_id`, `process_list_hist`.`status_id`,`as`.`status_name`,
                                if(`process_list_hist`.`desk_id`=0,\"-\",`ud`.`desk_name`) `deskname`,
                                concat_ws(' ', `users`.`user_first_name`, `users`.`user_middle_name`, `users`.`user_last_name`) as user_full_name,
                                `process_list_hist`.`id`,
                                `process_list_hist`.`process_id`,
                                `process_list_hist`.`ref_id`,
                                `process_list_hist`.`process_type_id`,
                                `process_list_hist`.`tracking_no`,
                                `process_list_hist`.`closed_by`,
                                `process_list_hist`.`locked_by`,
                                `process_list_hist`.`locked_at`,
                                `process_list_hist`.`desk_id`,
                                `process_list_hist`.`status_id`,
                                `process_list_hist`.`user_id`,
                                `process_list_hist`.`process_desc`,
                                `process_list_hist`.`created_by`,
                                `process_list_hist`.`on_behalf_of_user`,
                                `process_list_hist`.`updated_by`,
                                `process_list_hist`.`status_id`,
                                `process_list_hist`.`process_desc`,
                                `process_list_hist`.`process_id`,
                                `process_list_hist`.`updated_at`,
                                `process_list_hist`.`hash_value`,
                                 group_concat(`pd`.`file`) as files
                                from `process_list_hist`
                                left join `process_documents` as `pd` on `process_list_hist`.`id` = `pd`.`process_hist_id`
                                left join `user_desk` as `ud` on `process_list_hist`.`desk_id` = `ud`.`id`
                                left join `users` on `process_list_hist`.`updated_by` = `users`.`id`

                                left join `process_status` as `as` on `process_list_hist`.`status_id` = `as`.`id`
                                and `process_list_hist`.`process_type_id` = `as`.`process_type_id`
                                where `process_list_hist`.`process_id`  = '$process_list_id'
                                and `process_list_hist`.`hash_value` !=''
                                and `process_list_hist`.`status_id` != -1
                    group by `process_list_hist`.`process_id`,`process_list_hist`.`desk_id`, `process_list_hist`.`status_id`, process_list_hist.updated_at
                    order by process_list_hist.updated_at desc
                    limit 20
                    ");
            return view("ProcessPath::history-verification", compact('process_history'));
        } catch (Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[PPC-1007]');
            return Redirect::back();
        }
    }

    public static function batchProcessSet(Request $request)
    {
        try {
            Session::forget('is_delegation');
            $single_process_id_encrypt_current = '';
            if (!empty($request->current_process_id)) {
                $single_process_id_encrypt_current = $request->current_process_id;
            }
            if ($request->get('is_delegation') == true) {
                Session::put('is_delegation', 'is_delegation');
                $processData = ProcessList::leftJoin('process_type', 'process_list.process_type_id', '=', 'process_type.id')
                    ->where('process_list.id', Encryption::decodeId($single_process_id_encrypt_current))
                    ->first(['process_type.form_url', 'process_list.ref_id', 'process_list.process_type_id', 'tracking_no']);

                return response()->json([
                    'responseType' => 'single',
                    'url' => url('process/' . $processData->form_url . '/view/' . Encryption::encodeId($processData->ref_id) . '/' . Encryption::encodeId($processData->process_type_id))
                ]);
            }
            if (empty($request->process_id_array)) {
                return response()->json([
                    'responseType' => false,
                    'url' => '',
                ]);
            }

            //ob#code@start - (galib) can use the format: Session::forget(['key1', 'key2', 'key3']);
            Session::forget('batch_process_id');
            Session::forget('is_batch_update');
            Session::forget('single_process_id_encrypt');
            Session::forget('next_app_info');
            Session::forget('total_selected_app');
            Session::forget('total_process_app');
            //ob#code@end - (galib)

            $process_id_encryption = $request->process_id_array;
            $total_selected_app = count($process_id_encryption);

            $single_process_id_encrypt_next = null;
            $find_current_key = array_search($single_process_id_encrypt_current, $process_id_encryption); //find current key
            $keys = array_keys($process_id_encryption); //total key
            $nextKey = isset($keys[array_search($find_current_key, $keys) + 1]) ? $keys[array_search($find_current_key, $keys) + 1] : ''; //next key
            if (!empty($nextKey)) {
                $single_process_id_encrypt_next = $process_id_encryption[$nextKey]; //next process id
                $single_process_id_encrypt_next = Encryption::decodeId($single_process_id_encrypt_next);
            }
            $process_id = Encryption::decodeId($single_process_id_encrypt_current);

            //ob#code@start - (galib) can use the format: Session::put([
            //    'key1' => 'value1',
            //    'key2' => 'value2',
            //    'key3' => 'value3'
            //]);
            Session::put('batch_process_id', $request->process_id_array);
            Session::put('is_batch_update', 'batch_update');
            Session::put('single_process_id_encrypt', $single_process_id_encrypt_current);
            Session::put('total_selected_app', $total_selected_app);
            Session::put('total_process_app', $find_current_key + 1);
            //ob#code@end - (galib)

            $processData = ProcessList::leftJoin('process_type', 'process_list.process_type_id', '=', 'process_type.id')
                ->where('process_list.id', $process_id)
                ->first(['process_type.form_url', 'process_list.ref_id', 'process_list.process_type_id', 'tracking_no']);
            $nextAppInfo = 'null';
            if ($single_process_id_encrypt_next != null) {
                $nextAppInfo = ProcessList::where('process_list.id', $single_process_id_encrypt_next)->first(['tracking_no'])->tracking_no;
            }

            Session::put('next_app_info', $nextAppInfo);
            return response()->json([
                'responseType' => 'single',
                'url' => url('process/' . $processData->form_url . '/view/' . Encryption::encodeId($processData->ref_id) . '/' . Encryption::encodeId($processData->process_type_id))
            ]);
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1011]');
            return redirect()->back();
        }
    }

    public function skipApplication($single_process_id_encrypt_current)
    {
        try {
            $batch_process_id = Session::get('batch_process_id');

            $single_process_id_encrypt_next = null;
            $single_process_id_encrypt_second_next_key = null;
            $find_current_key = array_search($single_process_id_encrypt_current, $batch_process_id); //find current key
            $keys = array_keys($batch_process_id); //total key
            $nextKey = isset($keys[array_search($find_current_key, $keys) + 1]) ? $keys[array_search($find_current_key, $keys) + 1] : ''; //next key
            $second_nextKey = isset($keys[array_search($find_current_key, $keys) + 2]) ? $keys[array_search($find_current_key, $keys) + 2] : ''; //second next key

            if (!empty($nextKey)) {
                $single_process_id_encrypt_next = $batch_process_id[$nextKey]; //next process id
            }
            if (!empty($second_nextKey)) {
                $single_process_id_encrypt_second_next_key = $batch_process_id[$second_nextKey]; //next process id
            }

            if (empty($nextKey)) {
                $existProcessInfo = ProcessList::where('process_list.id', Encryption::decodeId($batch_process_id[0]))
                    ->first(['process_list.process_type_id']);
                Session::flash('error', 'Sorry data not found!.');
                return redirect('process/list/' . Encryption::encodeId($existProcessInfo->process_type_id));
            }

            Session::put('single_process_id_encrypt', $single_process_id_encrypt_next);
            $get_total_process_app = Session::get('total_process_app');
            Session::put('total_process_app', $get_total_process_app + 1);

            $nextAppInfo = 'null';
            if ($single_process_id_encrypt_second_next_key != null) {
                $nextAppInfo = ProcessList::where('process_list.id', Encryption::decodeId($single_process_id_encrypt_second_next_key))->first(['tracking_no'])->tracking_no;
            }
            Session::put('next_app_info', $nextAppInfo);

            $processData = ProcessList::leftJoin('process_type', 'process_list.process_type_id', '=', 'process_type.id')
                ->where('process_list.id', Encryption::decodeId($single_process_id_encrypt_next))
                ->first(['process_type.form_url', 'process_list.ref_id', 'process_list.process_type_id', 'tracking_no']);
            $redirectUrl = 'process/' . $processData->form_url . '/view/' . Encryption::encodeId($processData->ref_id) . '/' . Encryption::encodeId($processData->process_type_id);
            return redirect($redirectUrl);
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1003]');
            return redirect()->back();
        }
    }

    public function previousApplication($single_process_id_encrypt_current)
    {
        try {
            $batch_process_id = Session::get('batch_process_id');


            $single_process_id_encrypt_previous = null;
            $single_process_id_encrypt_next = null;
            $find_current_key = array_search($single_process_id_encrypt_current, $batch_process_id); //find current key
            $keys = array_keys($batch_process_id); //total key
            $previousKey = isset($keys[array_search($find_current_key, $keys) - 1]) ? $keys[array_search($find_current_key, $keys) - 1] : null; //next key

            if (!is_null($previousKey)) {
                $single_process_id_encrypt_previous = $batch_process_id[$previousKey]; //next process id
            }
            if (!empty($find_current_key)) {
                $single_process_id_encrypt_next = $batch_process_id[$find_current_key]; //next process id
            }


            if (is_null($previousKey)) {
                $existProcessInfo = ProcessList::where('process_list.id', Encryption::decodeId($batch_process_id[0]))
                    ->first(['process_list.process_type_id']);
                Session::flash('error', 'Sorry data not found!.');
                return redirect('process/list/' . Encryption::encodeId($existProcessInfo->process_type_id));
            }

            Session::put('single_process_id_encrypt', $single_process_id_encrypt_previous);
            $get_total_process_app = Session::get('total_process_app');
            Session::put('total_process_app', $get_total_process_app - 1);

            $nextAppInfo = 'null';
            if ($single_process_id_encrypt_next != null) {
                $nextAppInfo = ProcessList::where('process_list.id', Encryption::decodeId($single_process_id_encrypt_next))->first(['tracking_no'])->tracking_no;
            }
            Session::put('next_app_info', $nextAppInfo);
            $processData = ProcessList::leftJoin('process_type', 'process_list.process_type_id', '=', 'process_type.id')
                ->where('process_list.id', Encryption::decodeId($single_process_id_encrypt_previous))
                ->first(['process_type.form_url', 'process_list.ref_id', 'process_list.process_type_id', 'tracking_no']);
            $redirectUrl = 'process/' . $processData->form_url . '/view/' . Encryption::encodeId($processData->ref_id) . '/' . Encryption::encodeId($processData->process_type_id);
            return redirect($redirectUrl);
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1009]');
            return redirect()->back();
        }
    }


    public function batchUpdateClass($request, $desk)
    {
        //this is for batch update code
        $class = [];
        if ($request->has('process_search')) { //work for search parameter
            $class['button_class'] = 'common_batch_update_search';
            $class['input_class'] = 'batchInputSearch';
        } elseif ($request->has('status_wise_list')) {
            $class['button_class'] = "status_wise_batch_update";
            $class['input_class'] = "batchInputStatus";

            if ($request->get('status_wise_list') == 'is_delegation') {
                $class['button_class'] = 'is_delegation';
            }
        } else {
            $class['button_class'] = "common_batch_update";
            $class['input_class'] = '';
            if ($desk == 'my-desk' || $desk == 'my-delg-desk') { //for batch update
                $class['input_class'] = 'batchInput';
            }
        }

        return $class;
    }


    /**
     * @param $app_id
     * @param $process_type_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function certificateRegeneration($app_id, $process_type_id): \Illuminate\Http\RedirectResponse
    {
        $app_id = Encryption::decodeId($app_id);
        $process_type_id = Encryption::decodeId($process_type_id);

        $certificateRegenerate = certificateGenerationRequest($app_id, $process_type_id, 0, 'regenerate');
        if ($certificateRegenerate != true) {
            Session::flash('error', 'Sorry, something went wrong. [PPC-1045]');
            return redirect()->back();
        }

        Session::flash('success', 'Certificate regenerate process has been completed successfully.');
        return redirect()->back();
    }

    public static function statusWiseApps(Request $request)
    {
        $process_type_id = '';
        if (!empty($request->current_process_id)) {
            $process_type_id =  $request->current_process_id;
        }

        $userType = Auth::user()->user_type;
        $public_html = '';
        if (($userType == "1x101" || $userType == "4x404" || $userType == "5x505") && $process_type_id != '') {
            $status_wise_apps = ProcessList::statuswiseAppInDesks($process_type_id);
            $public_html = strval(view("ProcessPath::statuswiseApp", compact('status_wise_apps')));
        }


        return $public_html;
    }

    public function getDelegateUsers()
    {
        try {
            $delegateUser = Users::where('delegate_to_user_id', Auth::user()->id)->pluck('desk_id')->toArray();
            $tempArr = [];
            foreach ($delegateUser as $value) {
                $userDesk = explode(',', $value);
                $tempArr[] = $userDesk;
            }

            $arraySingle = [];
            if (!empty($tempArr)) {
                $arraySingle = call_user_func_array('array_merge', $tempArr);
            }
            return $arraySingle;
        } catch (\Exception $e) {
            Session::flash('error', 'Sorry! Something is Wrong.' . $e->getMessage() . '[PPC-1001]');
        }
    }
}
