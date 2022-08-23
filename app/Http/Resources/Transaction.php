<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_id' => $this->invoice_id,
            'type' => $this->type,
            'credit' => $this->credit,
            'debit' => $this->debit,
            'invoice_name' => $this->invoiceName,            
            'created_user' => $this->createdUser,            
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
