<?php

namespace App\Modules\Settings\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $table = 'contact_setting';

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($data) {
            $data->created_by = CommonFunction::getUserId();
            $data->updated_by = CommonFunction::getUserId();
        });

        static::updating(function ($data) {
            $data->updated_by = CommonFunction::getUserId();
        });
    }
}
