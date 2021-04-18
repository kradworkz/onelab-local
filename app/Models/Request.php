<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public function cartable()
    {
        return $this->morphOne('App\Models\Cart', 'cartable');
    }

    public function referral()
    {
        return $this->hasOne('App\Models\Referral', 'request_id');
    }


    public function samples()
    {
        return $this->hasMany('App\Models\RequestSample', 'request_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\DropdownList', 'type_id', 'id');
    }

    public function laboratory()
    {
        return $this->belongsTo('App\Models\DropdownList', 'laboratory_id', 'id');
    }

    public function purpose()
    {
        return $this->belongsTo('App\Models\DropdownList', 'purpose_id', 'id');
    }

    public function from()
    {
        return $this->belongsTo('App\Models\DropdownList', 'from_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Address', 'customer_id', 'id');
    }

    public function conforme()
    {
        return $this->belongsTo('App\Models\Conforme', 'conforme_id', 'id');
    }

    public function modeofrelease()
    {
        return $this->belongsTo('App\Models\DropdownList', 'modeofrelease_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo('App\Models\DropdownList', 'discount_id', 'id');
    }

    public function getReportDueAttribute($value)
    {
        return date('F d, Y', strtotime($value));
    }

    public function total()
    {
        $samples = $this->samples;
        $discount = $this->discount->percentage;
        
        $array = []; $fee = 0;

        foreach($samples as $sample){
           foreach($sample->analyses as $analysis){
               $fee += $analysis->fee;
           }

           foreach($sample->package as $analysis){
            $fee += $analysis->fee;
            }
        }
        $discount = round(($discount/100) * $fee);
        $total = $fee - $discount;

        return $wew = array(
            'subtotal' => number_format($fee,2),
            'total' => number_format($total,2),
            'discount' => number_format($discount,2)
        );
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
