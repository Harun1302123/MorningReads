<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Settings\Http\Requests\StoreUserManualRequest;
use App\Modules\Settings\Models\UserManual;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Traits\FileUploadTrait;

class UserManualController extends Controller
{

    use FileUploadTrait;

    protected string $list_route;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->list_route = 'user-manual.list';
    }

    /**
     * @param  Request  $request
     * @return View|JsonResponse
     *
     * @throws Exception
     */
    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax() && $request->isMethod('get')) {
                $list = UserManual::with('user:id,user_first_name')
                    ->select('tr_user_manual.id', 'tr_user_manual.title','tr_user_manual.status', 'tr_user_manual.updated_at', 'tr_user_manual.updated_by')
                    ->orderByDesc('tr_user_manual.id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('name', function ($row) {
                        return Str::limit($row->title, 50);
                    })

                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return optional($row->user)->user_first_name;
                    })
                    ->editColumn('status', function ($row) {
                        return $row->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="'.route('user-manual.edit', ['id' => Encryption::encodeId($row->id)]).'" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['name', 'status', 'action'])
                    ->make(true);
            }

            return view('Settings::user-manual.list');
        } catch (Exception $e) {
            Log::error("Error occurred in UserManualController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data load [UserManual-101]');

            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try {
            $data['card_title'] = 'Create New User Manual';
            $data['list_route'] = $this->list_route;

            return view('Settings::user-manual.create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in UserManualController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [UserManual-102] ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");

            return Redirect::back()->withInput();
        }
    }

    /**
     * @param  StoreUserManualRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreUserManualRequest $request): RedirectResponse
    {


        try {
            $msg = 'Data update successfully!';
            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $user_manual = UserManual::findOrFail($app_id);
            } else {
                $user_manual = new UserManual();
                $msg = 'Data save successfully!';
            }

            $user_manual->title = $request->get('title');
            $user_manual->status = $request->get('status');

            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $user_manual->document = $this->uploadFile($file);
            }

            $user_manual->save();

            Session::flash('success', $msg);

            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in UserManualController@Store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [UserManual-102] ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");

            return Redirect::back()->withInput();
        }
    }

    /**
     * @param  $id
     * @return View|RedirectResponse
     */
    public function edit($id): View|RedirectResponse
    {
        try {
            $decode_id = Encryption::decodeId($id);
            $data['data'] = UserManual::findOrFail($decode_id);
            $data['card_title'] = 'Edit User Manual';
            $data['list_route'] = $this->list_route;

            return view('Settings::user-manual.edit', $data);

        } catch (Exception $e) {
            Log::error("Error occurred in UserManualController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data edit [UserManual-103]');

            return redirect()->back();
        }
    }
}
