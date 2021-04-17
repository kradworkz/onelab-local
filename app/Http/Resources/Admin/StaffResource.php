<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'email' => $this->email,
            'status' => $this->status,
            'type' => $this->type,
            'laboratory' => $this->laboratory_id,
            'firstname' => $this->profile->firstname,
            'lastname' => $this->profile->lastname,
            'gender' => $this->profile->gender,
            'birthday' => $this->profile->birthday,
            'avatar' => ($this->profile->avatar == 'avatar.jpg') ? 'n/a' : $this->profile->avatar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
