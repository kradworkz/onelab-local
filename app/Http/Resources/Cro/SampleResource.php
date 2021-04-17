<?php

namespace App\Http\Resources\Cro;

use Illuminate\Http\Resources\Json\JsonResource;

class SampleResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'desc' => $this->description,
            'customer_desc' => $this->customer_description,
            'sampletype' => $this->sampletype,
            'sampletypename' => $this->sampletype->name,
            'analyses' => $this->analyses,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
