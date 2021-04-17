<?php

namespace App\Http\Resources\Lab;

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
            'status' => $this->status,
            'type' => $this->type,
            'samplecode' => $this->sample->code,
            'samplename' => $this->sample->name,
            'sampletype' => $this->sample->sampletype->name,
            'sampledescription' => $this->sample->description,
            'samplecustomerdescription' => $this->sample->customer_description,
            'received_date' => $this->sample->created_at,
            'due_date' => $this->sample->request->report_due,
            'testname' => $this->testservice->testname->name ,
            'method' => $this->testservice->method->name,
            // 'testname' => $this->analysisable,
            'analyst' => ($this->tag != null) ? $this->tag->user->profile->firstname.' '.$this->tag->user->profile->lastname : 'Not Available',
            'analyst_avatar' => ($this->tag != null) ? $this->tag->user->profile->avatar : 'avatar.jpg',
            'analyst_id' => ($this->tag != null) ? $this->tag->user->id : 'Not Available'
        ];
    }
}
