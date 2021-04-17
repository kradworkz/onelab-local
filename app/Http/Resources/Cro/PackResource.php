<?php

namespace App\Http\Resources\Cro;

use Illuminate\Http\Resources\Json\JsonResource;

class PackResource extends JsonResource
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
            'code' => $this->sample->code,
            'fee' => number_format($this->fee,2),
            'fee2' => $this->fee,
            'type' => 0,
            'testname' => $this->package->name,
            'method' => '-',
            'reference' => '',
            'status' => $this->status,
            'lists' =>  PackagelistResource::collection($this->sample->analyses),
        ];
    }
}
