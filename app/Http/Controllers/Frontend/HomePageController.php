<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libraries\Encryption;
use App\Modules\Settings\Models\ContactSetting;
use App\Modules\Settings\Models\AboutUs;
use App\Modules\Settings\Models\HomePageSlider;
use App\Modules\Settings\Models\Message;
use App\Modules\Settings\Models\News;
use App\Modules\Settings\Models\UserManual;
use App\Modules\Training\Models\TrSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;



class HomePageController extends Controller
{
    public function home()
    {

        $data['home_page_sliders'] = HomePageSlider::query()->select('slider_title', 'slider_image')
            ->whereStatus(1)->get();

        $data['messages'] = Message::query()
            ->select('id', 'name_en', 'designation_en', 'organization_en', 'image')
            ->whereStatus(1)
            ->orderBy('id', 'ASC')
            ->take(2)
            ->get();

        return view('home', $data);
    }

    public function contact()
    {
        try {
            $contacts['contacts'] = ContactSetting::query()
                ->where('is_archived', '0')
                ->orderby('id', 'DESC')
                ->get();

            return view('frontend.pages.contact', $contacts);
        } catch (\Exception $e) {
            Log::error("Error occurred in HomePageController@contact ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");

            return response()->json(['error' => 'An error occurred while fetching Contact page. Please try again later.'], 500);
        }
    }

    public function aboutUs()
    {
        try {
            $about_us['about_us'] = AboutUs::find(1);

            return view('frontend.pages.about_us', $about_us);
        } catch (\Exception $e) {
            Log::error("Error occurred in HomePageController@aboutUs ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");

            return response()->json(['error' => 'Oops! Something went wrong.Please try again later.'], 500);
        }
    }

    public function messagesDetail($id)
    {
        $decode_id = Encryption::decodeId($id);
        $data['message'] = Message::where('id', $decode_id)
            ->orderByDesc('id')
            ->where('status', 1)
            ->firstOrFail();

        return view('frontend.pages.message_details', $data);
    }

    public function userManual(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('get')) {
                $list = UserManual::select('id', 'title','document')
                ->orderBy('id', 'desc')
                ->where('status', 1)
                ->get();

                return Datatables::of($list)
                    ->editColumn('name', function ($row) {
                        return Str::limit($row->title, 50);
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="' . asset($row->document) . '" class="btn btn-xs btn-success" aria-hidden="true" target="_blank" download><i class="fa fa-download"></i> Download</a>';
                    })                                       
                    ->rawColumns(['name','action'])
                    ->make(true);
            }

            return view('frontend.pages.user_manual');
        } catch (\Exception $e) {
            Log::error("Error occurred in HomePageController@aboutUs ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            return response()->json(['error' => 'Oops! Something went wrong.Please try again later.'], 500);
        }
    }
    public function login()
    {
        return view('public_home.login');
    }

    public function mobileLogin()
    {
        return view('public_home.mobile_login');
    }

    public function emailLogin()
    {
        return view('public_home.email_login');
    }

    
    public function courseViewMore()
    {
        $course = TrSchedule::where('is_active', 1)->where('is_publish', 1)->orderBy('id', 'DESC')->get();
        return view('frontend.pages.course_view_more', compact('course'));
    }

    public function notice()
    {
        try {
            $data['notice'] = News::whereStatus(1)->get();

            return view('frontend.pages.newsDetails.notice', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in HomePageController@notice ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");

            return response()->json(['error' => 'An error occurred while fetching news details. Please try again later.'], 500);
        }
    }

    public function singleNotice($encode_id)
    {
        $id = Encryption::decodeId($encode_id);
        $data['data'] = News::where('id', $id)->first();
        $data['recent'] = News::where('id', '<>', $id)
            ->where('status', 1)
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();
        $data['related'] = News::whereStatus(1)->take(3)->get();

        return view('frontend.pages.newsDetails.single_notice_details', $data);
    }


}
