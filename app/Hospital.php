<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use SoftDeletes;

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function patients()
    {
        return $this->hasMany('App\Patient');
    }

    public function hospitalFee()
    {
        return $this->hasMany('App\HospitalFee');
    }

}
