<?php

namespace App\Http\Resources\Cro;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'email' => $this->user->email,
            'user_id' => $this->user->id,
            'name' => $this->name,
            'bussiness' => $this->bussiness,
            'industry' => $this->industry,
            'classification' => $this->classification,
            'type' => $this->type,
            'address' => $this->mainaddress()->address,
            'region' => $this->mainaddress()->region,
            'province' => $this->mainaddress()->province,
            'municipality' => $this->mainaddress()->municipality,
            'tel' => $this->mainaddress()->contact->tel_no,
            'mobile' => $this->mainaddress()->contact->mobile_no,
            'fax' => $this->mainaddress()->contact->fax,
            'sync' => ($this->sync == 1) ? 'Not Sync' : 'Synced',
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
