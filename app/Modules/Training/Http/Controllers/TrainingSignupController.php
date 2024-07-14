<?php

namespace App\Modules\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Encryption;
use App\Libraries\CommonFunction;
use Illuminate\Support\Facades\DB;
use App\Modules\Users\Models\Users;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Modules\Signup\Controllers\UserVerificationDataController;

class TrainingSignupController extends Controller
{
    
    public function identityVerifyConfirm(Request $request)
    {

        $rules = [];
        $messages = [];

        $rules['user_name'] = 'required';
        $rules['user_email'] = 'required|unique:users,user_email';
        $rules['user_mobile_no'] = 'required|unique:users,user_mobile';
        $rules['user_gender'] = 'required';
        // $rules['g-recaptcha-response'] = 'required';
        $rules['nid_number'] = 'required_if:identity_type,NID';
        $rules['nid_attachment'] = 'required_if:identity_type,NID|mimes:pdf|max:3072';

        $this->validate($request, $rules, $messages);

        try {

            DB::beginTransaction();
            $user_email = $request->user_email;
            $user_mobile_no =  $request->user_mobile_no;
            $user_name =  $request->user_name;
            $user = Users::firstOrNew(['user_email' => $user_email]);
            $user->user_first_name = $user_name;
            $user->user_middle_name = '';
            $user->user_last_name = '';
            $user->user_type = traineeUserType();
            $user->user_email = $user_email;
            $user->working_user_type = 'Trainee';
            $user->designation = 'Trainee';
            $user->nationality_type = 'bangladeshi';
            $user->user_mobile = $user_mobile_no;
            $user->user_gender =  $request->user_gender ? ucfirst( $request->user_gender) : 'Not defined';
            
            // identity_type wise data start
            $_authorization_file = null;
            if ($request->identity_type == 'nid') {
                $user->user_nid = $request->nid_number;
                if ($request->hasFile('nid_attachment')) {
                    $_authorization_file = $request->file('nid_attachment');
                }
            }elseif ($request->identity_type == 'passport') {
                $user->passport_no = $request->passport_number;
                if ($request->hasFile('passport_attachment')) {
                    $_authorization_file = $request->file('passport_attachment');
                }
            }elseif ($request->identity_type == 'tin') {
                $user->user_tin = $request->tin_number;
                if ($request->hasFile('tin_attachment')) {
                    $_authorization_file = $request->file('tin_attachment');
                }
            }elseif ($request->identity_type == 'brc') {
                $user->user_brc = $request->brc_number;
                if ($request->hasFile('brc_attachment')) {
                    $_authorization_file = $request->file('brc_attachment');
                }
            }
            $user->identity_type = $request->identity_type;
            if($_authorization_file){
                $yearMonth = date("Y") . "/" . date("m") . "/";
                $path = 'uploads/users/identity_attachments/' . $yearMonth;
                $full_name_concat = trim($user->user_first_name);
                $full_name = str_replace(' ', '_', $full_name_concat);
                $authorization_file = trim(uniqid($full_name . '_', true) . '.' . $_authorization_file->getClientOriginalExtension());
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $_authorization_file->move($path, $authorization_file);
                $authorization_file_path = $path . $authorization_file;
                $user->identity_attachment = $authorization_file_path;
            }
            // identity_type wise data end
            
            $token_no = hash('SHA256', "-" . $request->get('user_email') . "-");
            $encrypted_token = Encryption::encodeId($token_no);

            $user->user_hash = $encrypted_token;
            $user->user_agreement = 0;
            $user->user_verification = 'no';
            $user->first_login = 0;
            $user->working_company_id = 0;
            $user->is_approved = 0; // 1 = auto approved
            $user->user_status = 'inactive';
            $user->save();

            DB::commit();

            $receiverInfo[] = [
                'user_email' => $request->get('user_email'),
                'user_mobile' => $request->get('user_mobile')
            ];

            $appInfo = [
                'verification_link' => url('users/verify-created-user/' . ($encrypted_token))
            ];

            CommonFunction::sendEmailSMS('CONFIRM_ACCOUNT', $appInfo, $receiverInfo);
            Session::flash('success', 'User has been created successfully! An email has been sent to the user for account activation.');
            return Redirect::to('/login');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('TrainingSignupController : ' . $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine() . ' [TSC-125]');
            Session::flash('error', $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            // Session::flash('error', 'Something went wrong [TSC-125]');
            return Redirect::back()->withInput();
        }
    }
    
    public function old_identityVerifyConfirm(Request $request)
    {

        $rules = [];
        $messages = [];

        $rules['user_name'] = 'required';
        $rules['user_email'] = 'required';
        $rules['user_mobile_no'] = 'required';
        $rules['user_gender'] = 'required';
        $rules['g-recaptcha-response'] = 'required';

        $this->validate($request, $rules, $messages);

        try {

            DB::beginTransaction();
            $user_email = Session::get('oauth_data')->user_email;
            $user_mobile_no = Session::get('oauth_data')->mobile;
            $user_name = Session::get('oauth_data')->user_full_name;
            $user = Users::firstOrNew(['user_email' => $user_email]);
            $user->user_first_name = $user_name;
            $user->user_middle_name = '';
            $user->user_last_name = '';
            $user->user_type = traineeUserType();
            $user->user_email = $user_email;
            $user->working_user_type = 'Trainee';
            $user->designation = 'Trainee';
            $user->identity_type = 'none';
            // $user->nationality_type = 'Bangladeshi';
            $user->user_mobile = $user_mobile_no;
            $user->user_gender = Session::get('oauth_data')->gender ? ucfirst(Session::get('oauth_data')->gender) : 'Not defined';

            $user->user_agreement = 1;
            $user->user_verification = 'yes';
            $user->first_login = 0;
            // $user->social_login = 0;
            // $user->company_ids = 0;
            $user->working_company_id = 0;
            $user->is_approved = 1; // 1 = auto approved
            $user->user_status = 'active';
            $user->save();
            

            // User login
            Auth::loginUsingId($user->id);
            CommonFunction::GlobalSettings();
            $user->login_token = Encryption::encode(Session::getId());
            $user->save();

            // Update user verification data
            // $UserVerificationDataController = new UserVerificationDataController();
            // $UserVerificationDataController->updateNidTinPassportUserVerificationData($user_email);


            DB::commit();

            // Forget session data

            Session::flash('success', 'Successfully Registered! You can start training now.');
            return Redirect::to('training/upcoming-course');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('TrainingSignupController : ' . $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine() . ' [TSC-125]');
            Session::flash('error', $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            // Session::flash('error', 'Something went wrong [TSC-125]');
            return Redirect::back()->withInput();
        }
    }

}
