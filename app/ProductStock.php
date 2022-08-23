<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    use SoftDeletes;
    protected $fillable = ['id', 'product_id', 'batch_no','sell_price', 'hospital_id', 'created_user_id','created_at','updated_at','deleted_at'];
    
    
    public function product()
    {
        return $this->hasOne('App\Product','id','product_id');
    }
}
