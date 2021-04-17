<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
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
            'ornumber' => $this->ornumber,
            'deposit' => $this->deposit->name,
            'orseries' => $this->orseries->name,
            'updated_at' => $this->updated_at,
        ];
    }
}
