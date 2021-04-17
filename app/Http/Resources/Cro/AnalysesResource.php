<?php

namespace App\Http\Resources\Cro;

use Illuminate\Http\Resources\Json\JsonResource;

class AnalysesResource extends JsonResource
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
            'type' => $this->is_package,
            'testname' => $this->testservice->testname->name,
            'method' => $this->testservice->method->name,
            'reference' => $this->testservice->reference->name,
            'status' => $this->status,
            'lists' => ($this->type == 'Package') ? PackageListResource::collection($this->packages) : '',
        ];
    }
}
