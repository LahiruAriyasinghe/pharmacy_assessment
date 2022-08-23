<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return Str::title("{$this->title}. {$this->first_name} {$this->last_name}");
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function doctor()
    {
        return $this->hasOne('App\Doctor');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'created_user_id');
    }
}
