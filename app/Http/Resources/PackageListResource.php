<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageListResource extends JsonResource
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
            'testname' => $this->testservice->testname->name,
            'method' => $this->testservice->method->name,
            'reference' => $this->testservice->reference->name
        ];
    }
}
