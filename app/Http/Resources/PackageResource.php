<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'sampletype' => $this->sampletype->name,
            'name' => $this->name,
            'fee' => $this->fee,
            'lists' => PackageListResource::collection($this->lists),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
