<?php namespace App\Modules\Training\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class TrScheduleSession extends Model
{

    protected $table = 'tr_schedule_sessions';

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
    public function schedules()
    {
        return $this->belongsTo('App\Modules\Training\Models\TrSchedule', 'app_id');
    }

    public function speaker(){
        return $this->belongsTo('App\Modules\Training\Models\TrSpeaker', 'speaker_id');
    }

}
