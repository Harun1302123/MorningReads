<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Encryption;
use App\Modules\Settings\Models\AboutUs;
use App\Modules\Settings\Http\Requests\AboutUsRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AboutUsController extends Controller
{

    protected string $list_route;

    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function __construct()
    {
        $this->list_route = 'about-us.list';
    }

    /**
     * @param AboutUsRequest $request
     * @throws Exception
     */
    public function index()
    {
        try {
            $data['about_us'] = AboutUs::where('is_archived', 0)->get();

            return view('Settings::about-us.list', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in AboutUsController@index ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");

            return response()->json(['error' => 'Something went wrong during application data retrieval [AboutUs-101]'], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /**

     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {

            $id = Encryption::decodeId($request->id);
            $about_us = AboutUs::find($id);
            $about_us->details = $request->get('details');

            $about_us->save();

            Session::flash('success', 'Data updated successfully!');

            return redirect()->route("$this->list_route");

        } catch (\Exception $e) {
            Log::error("Error occurred in AboutUsController@store ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data update [AboutUs-102]');

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
            $data['data'] = AboutUs::findOrFail($decode_id);
            $data['card_title'] = 'Edit About Us';
            $data['list_route'] = $this->list_route;

            return view('Settings::about-us.edit', $data);
        } catch (\Exception $e) {
            Log::error("Error occurred in AboutUsController@edit ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data update [AboutUs-103]');

            return Redirect::back()->withInput();
        }
    }
}
