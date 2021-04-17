<?php

namespace App\Http\Resources\Cro;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerAddressResource extends JsonResource
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
            'customer_id' => $this->addressable->id,
            'name' => ($this->addressable->address->count() > 1) ? $this->addressable->name.' - '.$this->address : $this->addressable->name ,
            'mobile' => $this->contact->mobile_no,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
