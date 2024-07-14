<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Settings\Http\Requests\StoreMessageRequest;
use App\Modules\Settings\Models\Message;
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

class MessageController extends Controller
{

    use FileUploadTrait;

    protected string $list_route;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->list_route = 'message.list';
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
                $list = Message::with('user:id,user_first_name')
                    ->select('messages.id', 'messages.name_en', 'messages.name_bn', 'messages.designation_en', 'messages.designation_bn', 'messages.organization_en', 'messages.image', 'messages.status', 'messages.updated_at', 'messages.updated_by')
                    ->orderByDesc('messages.id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('name', function ($row) {
                        return Str::limit($row->name_en, 50);
                    })
                    ->editColumn('designation', function ($row) {
                        return Str::limit($row->designation_en, 50);
                    })
                    ->editColumn('organization', function ($row) {
                        return Str::limit($row->organization_en, 50);
                    })
                    ->editColumn('image', function ($row) {
                        return "<img class='img-thumbnail' src='".asset($row->image)."' alt='".htmlspecialchars($row->name_en)."'>";
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
                        return '<a href="'.route('message.edit', ['id' => Encryption::encodeId($row->id)]).'" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image', 'status', 'action'])
                    ->make(true);
            }

            return view('Settings::message.list');
        } catch (Exception $e) {
            Log::error("Error occurred in MessageController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data load [Message-101]');

            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try {
            $data['card_title'] = 'Create New Message';
            $data['list_route'] = $this->list_route;

            return view('Settings::message.create', $data);
        } catch (Exception $e) {
            Log::error("Error occurred in MessageController@create ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Message-102] ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");

            return Redirect::back()->withInput();
        }
    }

    /**
     * @param  StoreMessageRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreMessageRequest $request): RedirectResponse
    {

        try {
            $msg = 'Data update successfully!';
            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $message = Message::findOrFail($app_id);
            } else {
                $message = new Message();
                $msg = 'Data save successfully!';
            }

            $message->name_en = $request->get('name_en');
            $message->name_bn = $request->get('name_bn');
            $message->designation_en = $request->get('designation_en');
            $message->designation_bn = $request->get('designation_bn');
            $message->organization_en = $request->get('organization_en');
            $message->organization_bn = $request->get('organization_bn');
            $message->description_en = $request->get('description_en');
            $message->description_bn = $request->get('description_bn');
            $message->status = $request->get('status');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $message->image = $this->uploadFile($file);
            }

            $message->save();

            Session::flash('success', $msg);

            return redirect()->route("$this->list_route");

        } catch (Exception $e) {
            Log::error("Error occurred in MessageController@Store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', "Something went wrong during application data load [Message-102] ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");

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
            $data['data'] = Message::findOrFail($decode_id);
            $data['card_title'] = 'Edit Message';
            $data['list_route'] = $this->list_route;

            return view('Settings::message.edit', $data);

        } catch (Exception $e) {
            Log::error("Error occurred in MessageController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data edit [Message-103]');

            return redirect()->back();
        }
    }
}
