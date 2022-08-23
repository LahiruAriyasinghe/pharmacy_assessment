<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['id', 'name','uom', 'product_type_id', 'hospital_id', 'created_user_id','created_at'];
}
