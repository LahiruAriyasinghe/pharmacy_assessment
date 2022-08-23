<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;
    protected $fillable = ['id', 'name', 'hospital_id', 'created_user_id','created_at'];
}
