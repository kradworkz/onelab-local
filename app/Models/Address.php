<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function addressable()
    {
        return $this->morphTo();
    }

    public function contact()
    {
        return $this->morphOne('App\Models\Contact', 'contactable');
    }

    public function transaction()
    {
        return $this->hasMany('App\Models\FinanceTransaction', 'customer_id');
    }

    public function trans()
    {
        return $this->hasMany('App\Models\FinanceTransaction', 'customer_id')->where('status','Pending')->first();
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\LocationRegion', 'region_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\LocationProvince', 'province_id', 'id');
    }

    public function municipality()
    {
        return $this->belongsTo('App\Models\LocationMunicipality', 'municipality_id', 'id');
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
