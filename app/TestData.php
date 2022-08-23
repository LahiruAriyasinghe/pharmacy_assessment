<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestData extends Model
{
    protected $table = 'test_datas';

    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function category()
    {
        return $this->belongsTo('App\TestDataCategory', 'test_data_category_id', 'id');
    }

    public function resultCategory()
    {
        return $this->belongsTo('App\TestDataResultCategory', 'test_data_result_category_id');
    }

    public function ranges()
    {
        return $this->hasMany('App\TestDataRanges');
    }
}
