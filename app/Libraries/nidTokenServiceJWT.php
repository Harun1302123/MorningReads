<?php

namespace App\Libraries;

use App\Modules\Signup\Models\UserVerificationOtp;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Session;

class nidTokenServiceJWT
{

    public function generateNIDToken($clientData)
    {
        try {
            $tokenEncodeData = [
                'client_id' => $clientData->client_id,
                'client_secret_key' => $clientData->client_secret_key,
                "exp" => time() + 180
            ];


            $currentTime = Carbon::now();
            $otpExpireTime = $currentTime->addMinutes(3);

            $jwtToken = JWT::encode($tokenEncodeData, $clientData->encryption_key, 'HS256');
//            $jwtToken = JWT::encode($tokenEncodeData, $clientData->client_secret_key, 'HS256');

            $tokenResponse['status'] = 'success';
            $tokenResponse['token'] = $jwtToken;
            $tokenResponse['expire_in'] = $otpExpireTime;
            return $tokenResponse;
        } catch (\Error $e) {
            return [
                'status' => 'error',
                'msg' => 'An error occurred: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'msg' => CommonFunction::showErrorPublic($e->getMessage())
            ];
        }
    }

    public function storeNIDToken($jwtTokenArray)
    {
        $userVerificationTokenData = UserVerificationOtp::where('user_email', Session::get('oauth_data')->user_email)
            ->where('user_mobile', Session::get('oauth_data')->user_mobile)
            ->where('otp_status', UserVerificationOtp::OTP_UPDATE)
            ->orderBy('id', 'DESC')
            ->first();
        $userVerificationTokenData->token = $jwtTokenArray['token'];
        $userVerificationTokenData->token_expire_time = $jwtTokenArray['expire_in'];
        $userVerificationTokenData->token_status = UserVerificationOtp::OTP_SENT;
        $userVerificationTokenData->save();
    }

    public function checkNIDTokenValidity($token, $encryption_key)
    {
        try {
            /**
             * if there have an expire time in your payload while encoding JWT,
             * the JWT decode function() will automatically check the expire time.
             * No need to do extra checking.
             */
            $decoded_token = JWT::decode($token, new Key($encryption_key, 'HS256'));

            $client_id = $decoded_token->client_id;
            $client_secret_key = $decoded_token->client_secret_key;

            // Check valid credential
            if ($client_id == config('app.NID_JWT_ID') && $client_secret_key == config('app.NID_JWT_SECRET_KEY')) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
