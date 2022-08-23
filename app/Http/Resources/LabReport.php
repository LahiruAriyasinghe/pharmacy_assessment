<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LabReport extends JsonResource
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
            'name' => $this->name,
            'acronym' => $this->acronym,
            'fee' => $this->fee,
            'lab_report_categories_id' => $this->lab_report_categories_id,
            'test_datas' => $this->test_datas,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
