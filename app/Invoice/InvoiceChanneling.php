<?php

namespace App\Invoice;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceChanneling extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    
    public $incrementing = false;

    protected $guarded = [];

    public function transaction()
    {
        return $this->morphOne('App\Transaction', 'invoice');
    }

    public function pdfFile()
    {
        return $this->morphOne('App\Invoice\InvoiceFile', 'invoice');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    public function channelingSession()
    {
        return $this->belongsTo('App\ChannelingSession');
    }

    /**
     *  generate custom invoice id
     *  id contains 13 digits with 4 daily invoice sequence
     * 
     *  example: 
     *  110120072810003
     *      11      - hospital id
     *      01      - hospital branch id
     *      200728  - ymd
     *      2       - channeling invoice
     *      0003    - 2020/07/28 date invoice sequence
     */ 
    protected static function booted()
    {
        $invoiceModalId = 2;
        $hospitalId = Auth::user()->hospital->id;
        $branchId = '01';
        $today = Carbon::now()->format('ymd');
        $invoiceStart = "{$hospitalId}{$branchId}{$today}{$invoiceModalId}";

        $lastInvoice = InvoiceChanneling::withTrashed()
            ->select('id')
            ->where('hospital_id', $hospitalId)
            ->where(DB::raw('CAST(`id` AS CHAR)'), 'like', $invoiceStart . '%')
            ->orderBy('issued_at', 'desc')->first();

        $currentId = 0;

        if ($lastInvoice) {
            $currentId =  $lastInvoice->id % 10000;
        }

        $newId = sprintf("%04d", $currentId + 1);

        if ($currentId > 9999) {
            abort('403', 'invoice id limit exceeds in InvoiceLab');
        }

        $newInvoiceId = "{$invoiceStart}{$newId}";

        static::creating(function ($invoice) use ($newInvoiceId) {
            $invoice->id = $newInvoiceId;
            $invoice->issued_at = $invoice->freshTimestamp();
        });
    }
}
