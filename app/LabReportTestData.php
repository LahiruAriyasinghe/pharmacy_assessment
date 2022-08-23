<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabReportTestData extends Model
{
    protected $guarded = [];

    public function testData()
    {
        return $this->belongsTo('App\TestData', 'test_datas_id', 'id');
    }
}
