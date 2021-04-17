<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;

class ChequeResource extends JsonResource
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
            'bank' => $this->bank,
            'account' => $this->account_number,
            'amount' => $this->amount,
            'cheque_at' => $this->cheque_date,
            'updated_at' => $this->updated_at,
        ];
    }
}
