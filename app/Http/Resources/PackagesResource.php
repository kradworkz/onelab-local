<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackagesResource extends JsonResource
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
            'agency_id' => $this->agency->id,
            'sampletype_id' => $this->sampletype->id,
            'name' => $this->name,
            'fee' => $this->fee,
            'lists' => DefaultResource::collection($this->lists),
        ];
    }
}
