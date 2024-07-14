<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Encryption;
use App\Modules\Settings\Http\Requests\ContactSettingRequest;
use App\Modules\Settings\Models\ContactSetting;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ContactSettingController extends Controller
{

    protected string $list_route;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->list_route = 'contact-setting.list';
    }

    /**
     *
     * @throws Exception
     */
    public function index(): View|RedirectResponse
    {
        try {
            $data['data'] = ContactSetting::where('is_archived', 0)->first();

            return view('Settings::contact-setting.list', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in ContactSettingController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data load [G.Setting-101]');

            return redirect()->back();
        }
    }

    /**
     * @param  ContactSettingRequest  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {

            $id = Encryption::decodeId($request->id);
            $general_setting = ContactSetting::find($id);
            $general_setting->contact_person_one_name_en = $request->get('contact_person_one_name_en');
            $general_setting->contact_person_one_name_bn = $request->get('contact_person_one_name_bn');
            $general_setting->contact_person_one_phone = $request->get('contact_person_one_phone');
            $general_setting->contact_person_one_email = $request->get('contact_person_one_email');
            $general_setting->contact_person_one_location = $request->get('contact_person_one_location');
            $general_setting->contact_person_two_name_en = $request->get('contact_person_two_name_en');
            $general_setting->contact_person_two_name_bn = $request->get('contact_person_two_name_bn');
            $general_setting->contact_person_two_location = $request->get('contact_person_two_location');
            $general_setting->contact_person_two_phone = $request->get('contact_person_two_phone');
            $general_setting->contact_person_two_email = $request->get('contact_person_two_email');
            $general_setting->contact_person_three_name_en = $request->get('contact_person_three_name_en');
            $general_setting->contact_person_three_name_bn = $request->get('contact_person_three_name_bn');
            $general_setting->contact_person_three_designation_en = $request->get('contact_person_three_designation_en');
            $general_setting->contact_person_three_designation_bn = $request->get('contact_person_three_designation_bn');
            $general_setting->contact_person_three_phone = $request->get('contact_person_three_phone');
            $general_setting->contact_person_three_email = $request->get('contact_person_three_email');

            $general_setting->save();

            Session::flash('success', 'Data updated successfully!');

            return redirect()->route("$this->list_route");

        } catch (\Exception $e) {
            Log::error("Error occurred in ContactSettingController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data update [G.Setting-102]');

            return Redirect::back()->withInput();
        }
    }

    /**
     * @param  $id
     * @return View|RedirectResponse
     */
    public function edit(): View|RedirectResponse
    {
        try {
            $data['card_title'] = 'Edit Contact Setting';
            $data['list_route'] = $this->list_route;
            $data['data'] = ContactSetting::where('is_archived', 0)->first();

            return view('Settings::contact-setting.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in ContactSettingController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data edit [G.Setting-103]');

            return redirect()->back();
        }
    }
}
