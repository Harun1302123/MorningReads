<?php namespace App\Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Libraries\CommonFunction;

class Dashboard extends Model {

    protected $table = 'dashboard_object';
    protected $fillable = [
        'db_obj_title',
        'db_obj_caption',
        'db_user_id',
        'db_obj_type',
        'db_obj_para1',
        'db_obj_para2',
        'db_obj_status',
        'db_obj_sort',
        'db_user_type',
        'updated_by',
    ];


    public static function boot()
    {
        parent::boot();
        
        static::creating(function($post)
        {
            $post->updated_by = CommonFunction::getUserId();
        });

        static::updating(function($post)
        {
            $post->updated_by = CommonFunction::getUserId();
        });

    }
    
    public function getDashboardObject()
    {
        $data = Dashboard::where('db_obj_status', 1)
            ->where('db_user_type','LIKE','%'.Auth::user()->user_type.'%')
            ->get();
        return $data;
    }

/********************End of Model Class*****************/
}
