<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestDataResultCategory extends Model
{
    protected $casts = [
        'is_editable' => 'boolean',
    ];

    public static function getResultCategoryTypes($resultCategoryId)
    {
        $resultCategory = TestDataResultCategory::find($resultCategoryId);
        return explode(',', $resultCategory->result_category_types);
    }
}
