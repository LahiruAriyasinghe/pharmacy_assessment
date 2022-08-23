<?php

namespace App\Invoice;

use Illuminate\Database\Eloquent\Model;

class InvoiceLabReport extends Model
{
    protected $fillable = ['lab_report_id', 'fee', 'sample_no', 'result', 'hospital_id', 'created_user_id'];

    protected $casts = [
        'result' => 'object',
    ];

    public function labReport()
    {
        return $this->belongsTo('App\LabReport')->withTrashed();
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\User', 'approved_user_id');
    }

    public function labInvoice()
    {
        return $this->belongsTo('App\Invoice\InvoiceLab', 'invoice_lab_id', 'id');
    }

    protected static function booted()
    {
        //TODO: fix sample_no generation pattern
        static::created(function ($report) {
            $report->sample_no = $report->hospital_id . $report->lab_report_id . $report->id;
            $report->save();
        });
    }
}
