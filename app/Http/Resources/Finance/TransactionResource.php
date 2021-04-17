<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'transaction_no' => $this->transaction_no,
            'status' => $this->status,
            'customer' =>  ($this->customer->addressable->address->count() > 1) ? $this->customer->addressable->name.' - '.$this->customer->address : $this->customer->addressable->name ,
            'mode' => ($this->payment == null) ? 'Not Available' : $this->payment->name,
            'collection' => ($this->collection == null) ? 'Not Available' : $this->collection->name,
            'updated_at' => $this->updated_at,
            'or' => new ReceiptResource($this->receipt),
            'cheque' => new ChequeResource($this->cheque),
            'carts' => CartResource::collection($this->carts)
        ];
    }
}
