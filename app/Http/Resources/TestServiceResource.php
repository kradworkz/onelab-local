<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestServiceResource extends JsonResource
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
            'laboratory_id' => $this->sampletype->laboratory_id,
            'sampletype_id' => $this->sampletype->id,
            'sampletype' => $this->sampletype->name,
            'testname_id' => $this->testname->id,
            'testname' => $this->testname->name,
            'method_id' => $this->method->id,
            'method' => $this->method->name,
            'reference_id' => $this->reference->id,
            'reference' => $this->reference->name,
            'fee' => $this->fee,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
