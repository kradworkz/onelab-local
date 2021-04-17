<?php

namespace App\Http\Resources\Cro;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'payment_status' => ($this->cartable != null) ? $this->cartable->transaction->status : 'Pending',
            'reference' => ($this->reference != 'n/a') ? $this->reference : 'Not yet Available',
            'type' => $this->type->name,
            'laboratory' => $this->laboratory->name,
            'laboratory_id' => $this->laboratory->id,
            'purpose' => $this->purpose->name,
            'from' => $this->from->name,
            'modeofrelease' => $this->modeofrelease->name,
            'discount' => $this->discount->name.' ('.$this->discount->percentage.'%)',
            'percentage' => $this->discount->percentage,
            'customer' => ($this->customer->addressable->address->count() > 1) ? $this->customer->addressable->name.' - '.$this->customer->address : $this->customer->addressable->name ,
            'transaction_no' => ($this->cartable == null) ? $this->customer->trans()->transaction_no : $this->cartable->transaction->transaction_no,
            'transaction_status' =>($this->cartable == null) ?  $this->customer->trans()->status : $this->cartable->transaction->status,
            'transaction_date' => ($this->cartable == null) ? $this->customer->trans()->created_at : $this->cartable->transaction->created_at,
            'or_receipt' => ($this->cartable == null) ? 'Not yet Available' : $this->cartable->transaction->receipt->ornumber ,
            'or_date' =>($this->cartable == null) ? 'Date not Specified' : $this->cartable->transaction->receipt->created_at ,
            'conforme' => $this->conforme->name,
            'mobile' => $this->conforme->mobile_no,
            'due_at' => $this->report_due,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
