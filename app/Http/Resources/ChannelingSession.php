<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use Carbon\Carbon;

class ChannelingSession extends JsonResource
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
            'room_no' => $this->room_no,
            'doctor' => $this->doctor ? $this->doctor->user : null,            
            'nurse' => $this->nurseUser,            
            'week_day' => $this->week_day,            
            'start_at' => $this->start_at,            
            'end_at' => $this->end_at,            
            'maximum_patients' => $this->maximum_patients,            
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
