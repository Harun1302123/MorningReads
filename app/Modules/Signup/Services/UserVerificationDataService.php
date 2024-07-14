<?php

namespace App\Modules\Signup\Services;

use App\Modules\Signup\Models\UserVerificationData;
use Illuminate\Support\Facades\Session;

class UserVerificationDataService
{

    public function storeUserVerificationData($user_email)
    {
        try {
            $userVerificationData = UserVerificationData::firstOrNew([
                'user_email' => $user_email
            ]);
            $userVerificationData->nationality_type = \session('nationality_type');
            $userVerificationData->identity_type = \session('identity_type');
            $userVerificationData->nid_info = Session::has('nid_info') ? Session::get('nid_info') : '';
            $userVerificationData->eTin_info = Session::has('eTin_info') ? Session::get('eTin_info') : '';
            $userVerificationData->passport_info = Session::has('passport_info') ? Session::get('passport_info') : '';
            $userVerificationData->save();
        } catch (\Exception $e){
            Session::flash('error', $e->getMessage() . '[UVDC-1001]');
            return \redirect()->back();
        }
    }

    public function removeUserVerificationData($user_email)
    {
        try {
            UserVerificationData::where('user_email', $user_email)->delete();
        } catch(\Exception $e){
            Session::flash('error', $e->getMessage() . '[UVDC-1002]');
            return \redirect()->back();
        }
    }
}
