<?php namespace App\Modules\Training\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class TrSpeaker extends Model
{

    protected $table = 'tr_speakers';

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = CommonFunction::getUserId();
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function ($post) {
            $post->updated_by = CommonFunction::getUserId();
        });

    }

    public function scheduleSessions()
    {
        return $this->hasOne('App\Modules\Training\Models\TrScheduleSession', 'speaker_id', 'id');
    }
     
}
