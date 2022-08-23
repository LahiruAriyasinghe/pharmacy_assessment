<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','specialty_id','fee','note'];

    public function specialty()
    {
        return $this->belongsTo('App\Specialty');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function sessions()
    {
        return $this->hasMany('App\ChannelingSession');
    }

}
