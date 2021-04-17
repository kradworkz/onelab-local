<?php

namespace App\Http\Resources\Lab;

use Illuminate\Http\Resources\Json\JsonResource;

class SampletypeResource extends JsonResource
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
            'id' => $this->sampletype->id,
            'name' => $this->sampletype->name
        ];
    }
}
