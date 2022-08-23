<?php

namespace App\Log;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ResetPassword extends Model
{
    const CREATED_AT = 'logged_at';
    protected $table = 'log_reset_passwords';
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($log) {
            $log->admin_user_id = Auth::id();
            $log->logged_at = $log->freshTimestamp();
        });
    }
}
