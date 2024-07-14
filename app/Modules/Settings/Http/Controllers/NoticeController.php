<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Settings\Http\Requests\StoreNoticeRequest;
use App\Modules\Settings\Models\News;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class NoticeController extends Controller
{
    use FileUploadTrait;

    protected int $add_permission;

    protected int $edit_permission;

    protected string $list_route;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->list_route = 'notice.list';
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

                $list = News::with('user:id,user_first_name')
                    ->select('news.id', 'news.title_en', 'news.image', 'news.status', 'news.updated_at', 'news.updated_by')
                    ->orderByDesc('news.id')
                    ->get();

                return Datatables::of($list)
                    ->editColumn('image', function ($row) {
                        return "<img width='150px' class='img-thumbnail' src='".asset($row->image)."' alt='".htmlspecialchars($row->title_en)."'>";
                    })
                    ->editColumn('updated_at', function ($row) {
                        return CommonFunction::formatLastUpdatedTime($row->updated_at);
                    })
                    ->editColumn('updated_by', function ($row) {
                        return $row->user->user_first_name;
                    })
                    ->editColumn('status', function ($row) {
                        return $row->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="'.route('notice.edit', ['id' => Encryption::encodeId($row->id)]).'" class="btn btn-sm btn-outline-dark"> <i class="fa fa-edit"></i> Edit</a><br>';
                    })
                    ->rawColumns(['image', 'title_en', 'status', 'action'])
                    ->make(true);
            }

            return view('Settings::notice.list');

        } catch (Exception $e) {
            Log::error("Error occurred in NoticeController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data load [Notice -101]');

            return Response::json(['error' => CommonFunction::showErrorPublic($e->getMessage())], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        $data['card_title'] = 'Create New Notice ';
        $data['list_route'] = $this->list_route;

        return view('Settings::notice.create', $data);
    }

    /**
     * @param  StoreNoticeRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreNoticeRequest $request): RedirectResponse
    {
        try {

            $msg = 'Data update successfully!';
            if ($request->get('id')) {
                $app_id = Encryption::decodeId($request->get('id'));
                $notice = News::findOrFail($app_id);
            } else {
                $notice = new News();
                $msg = 'Data save successfully!';
            }
            $notice->title_en = $request->get('title_en');
            $notice->title_bn = $request->get('title_bn');
            $notice->content_en = $request->get('content_en');
            $notice->content_bn = $request->get('content_bn');
            $notice->status = $request->get('status');

            if ($request->hasFile('image')) {
                $notice->image = $this->uploadFile($request->file('image'));
            }

            $notice->save();

            Session::flash('success', $msg);

            return redirect()->route($this->list_route);

        } catch (\Exception $e) {
            Log::error("Error occurred in NoticeController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data store [Notice -102]');

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
            $data['data'] = News::findOrFail($decode_id);
            $data['card_title'] = 'Edit Notice';
            $data['list_route'] = $this->list_route;

            return view('Settings::notice.edit', $data);

        } catch (Exception $e) {
            Log::error("Error occurred in NoticeController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data edit [Notice -103]');

            return redirect()->back();
        }
    }
}
