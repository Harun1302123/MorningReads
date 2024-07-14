<?php

namespace App\Modules\Settings\Models;

use App\Libraries\CommonFunction;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $table = 'news';

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id')->withDefault();
    }
}
