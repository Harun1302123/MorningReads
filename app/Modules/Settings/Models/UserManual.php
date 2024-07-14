<?php

namespace App\Modules\Settings\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserManual extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tr_user_manual';
    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();

        // Set the created_by and updated_by fields during model creation
        static::creating(function ($data) {
            if (auth()->check()) {
                $data->created_by = auth()->id();
                $data->updated_by = auth()->id();
            }
        });

        // Update the updated_by field during model update
        static::updating(function ($data) {
            if (auth()->check()) {
                $data->updated_by = auth()->id();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')->withDefault();
    }
}
