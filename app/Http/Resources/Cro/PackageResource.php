<?php

namespace App\Http\Resources\Cro;

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
            'agency' => $this->agency->acronym,
            'name' => $this->name,
            'fee' => $this->fee,
            'lists' =>PackagelistResource::collection($this->lists),
        ];
    }
}
