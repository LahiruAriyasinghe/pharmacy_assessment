<?php

namespace App\Invoice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceFile extends Model
{
    use SoftDeletes;

    protected $fillable = ['path'];

    public function invoice()
    {
        return $this->morphTo();
    }
}
