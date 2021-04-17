<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\DropdownList', 'type_id', 'id');
    }

    public function bussiness()
    {
        return $this->belongsTo('App\Models\DropdownList', 'bussiness_id', 'id');
    }

    public function classification()
    {
        return $this->belongsTo('App\Models\DropdownList', 'classification_id', 'id');
    }

    public function industry()
    {
        return $this->belongsTo('App\Models\DropdownList', 'industry_id', 'id');
    }

    public function mainaddress()
    {
        return $this->morphMany('App\Models\Address', 'addressable')->where('type','Customer')->first();
    }

    public function address()
    {
        return $this->morphMany('App\Models\Address', 'addressable');
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
