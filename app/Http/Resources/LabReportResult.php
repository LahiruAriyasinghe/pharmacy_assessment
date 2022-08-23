<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LabReportResult extends JsonResource
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
            'name' => $this->labReport ? $this->labReport->name : null,
            'lab_report_id' => $this->lab_report_id,
            'invoice_id' => $this->invoice_lab_id,
            'fee' => $this->fee,
            'sample_no' => $this->sample_no,
            'result' => $this->result,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
