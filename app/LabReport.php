<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabReport extends Model
{
    use SoftDeletes;
    protected $fillable = ['id', 'name', 'fee', 'hospital_id', 'lab_report_categories_id', 'created_user_id'];

    public function labInvoices()
    {
        return $this->hasMany('App\Invoice\InvoiceLabReport');
    }

    public function testData()
    {
        return $this->hasMany('App\LabReportTestData');
    }

    public function category()
    {
        return $this->belongsTo('App\LabReportCategory', 'lab_report_categories_id');
    }
}
