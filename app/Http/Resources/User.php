<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $role = $this->roles ? $this->roles->first() : null;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'full_name' => $this->full_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'gender' => $this->gender,
            'contact' => $this->contact,
            'role' => $role ? $role->id : null,
            'role_name' => $role ? substr($role->name, strpos($role->name, "-") + 1) : null,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'links' => [
                'self' => route('resources.users.show', $this),
            ],
        ];
    }
}
