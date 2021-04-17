<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
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

    public function mainaddress()
    {
        return $this->morphMany('App\Models\Address', 'addressable')->where('type','Main')->first();
    }
    
    public function address()
    {
        return $this->morphMany('App\Models\Address', 'addressable');
    }

    public function contact()
    {
        return $this->morphOne('App\Models\Contact', 'contactable');
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
