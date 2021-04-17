<?php

namespace App\Http\Resources\Cro;

use Illuminate\Http\Resources\Json\JsonResource;

class AnalysisResource extends JsonResource
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
            'testname' => $this->testname->name,
            'method' => $this->method->name,
            'reference' => $this->reference->name,
            'fee' => $this->fee
        ];
    }
}
