<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks;
use App\Models\User;
use App\Models\TimeAllocated;

class TimeAllocated extends Model
{

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function task()
    {
        return $this->hasOne(Tasks::class, 'id', 'task_id');
    }
}
