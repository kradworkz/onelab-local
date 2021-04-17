<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionRequestResource extends JsonResource
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
            'reference' => $this->reference,
            // 'total' => number_format($this->total(),2),
            'total' => $this->total()['total'],
            'subtotal' => $this->total()['subtotal'],
            'discount' => $this->total()['discount'],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
