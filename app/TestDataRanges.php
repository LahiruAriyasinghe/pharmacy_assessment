<?php

namespace App;

use App\Patient;
use App\TestData;
use Illuminate\Database\Eloquent\Model;

class TestDataRanges extends Model
{
    protected $guarded = [];

    public function testData()
    {
        return $this->belongsTo('App\TestData');
    }

    public static function getTestDataRangeCondition(Patient $patient, $testData, $result)
    {
        $rangeData = TestDataRanges::where([
            ['gender', '=', $patient->gender],
            ['age_min', '<', $patient->age],
            ['age_max', '>=', $patient->age],
            ['range_min', '<', $result],
            ['range_max', '>=', $result],
            ['test_data_id', '=', $testData->id],
        ])->first();

        return $rangeData;
    }

    public static function getPreferredRange(Patient $patient, $testData)
    {
        $preferredRangeData = TestDataRanges::where([
            ['gender', '=', $patient->gender],
            ['age_min', '<', $patient->age],
            ['age_max', '>=', $patient->age],
            ['condition', '=', 'normal'],
            ['test_data_id', '=', $testData->id],
        ])->first();

        return $preferredRangeData;
    }
}
