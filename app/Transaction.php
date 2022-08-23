<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function invoice()
    {
        return $this->morphTo();
    }

    public function invoiceName()
    {
        return $this->belongsTo('App\InvoiceType', 'invoice_type', 'type');
    }

    public function createdUser()
    {
        return $this->belongsTo('App\User', 'created_user_id')->withTrashed();
    }

    protected static function booted()
    {
        $userId = Auth::id();
        $hospitalId = Auth::user()->hospital->id;

        // get user last transaction
        $lastTransaction = Transaction::withTrashed()
            ->select('total')
            ->where('created_user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        $lastBalance = $lastTransaction ? $lastTransaction->total : 0;

        static::creating(function ($invoice) use ($userId, $hospitalId, $lastBalance) {
            $total = 0;

            // validate credit debit values
            if ($invoice->credit < 0 | $invoice->debit < 0) {
                abort('403', 'invalid transaction amount entered');
            }

            // calculate total value
            if ($invoice->credit > 0) {
                // credit transaction
                $total = $lastBalance + $invoice->credit;
            } else {
                // debit transaction
                $total = $lastBalance - $invoice->debit;
            }

            $invoice->total = $total;
            $invoice->hospital_id = $hospitalId;
            $invoice->created_user_id = $userId;
        });

    }
}
