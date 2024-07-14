<?php

namespace App\Modules\ProcessPath\Models;

use App\Libraries\CommonFunction;
use Illuminate\Database\Eloquent\Model;

class UserDesk extends Model {

    protected $table = 'user_desk';
    protected $fillable = array(
        'id',
        'desk_name',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    );
    
}
