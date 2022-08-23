<?php

namespace App;
use App\Doctor;
use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChannelingSession extends Model
{
    use SoftDeletes;

    protected $table = 'channeling_sessions';

    public function nurseUser()
    {
        return $this->hasOne('App\User','id','nurse_id');
    }

    public function doctor()
    {
        return $this->hasOne('App\Doctor','id','doctor_id');
    }

    public function channels()
    {
        return $this->hasMany('App\Invoice\InvoiceChanneling');
    }
}
