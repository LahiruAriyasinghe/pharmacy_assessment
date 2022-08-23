<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attachment;
use App\Models\Quotation;

class UserPrescription extends Model
{

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'prescription_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class, 'prescription_id', 'id');
    }
}
