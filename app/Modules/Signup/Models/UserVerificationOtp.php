<?php namespace App\Modules\Signup\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerificationOtp extends Model
{
    protected $table = 'users_verification_otp';
    const NO_OTP = 0;
    const OTP_SENT = 1;
    const OTP_UPDATE = 2;

    protected $fillable = array(
        'user_email', 'user_mobile', 'otp', 'otp_expire_time', 'otp_count', 'otp_status', 'sms_response', 'token',
        'token_expire_time', 'token_status', 'created_at', 'updated_at'
    );
}