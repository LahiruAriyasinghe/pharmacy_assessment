<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalFee extends Model
{
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
}
