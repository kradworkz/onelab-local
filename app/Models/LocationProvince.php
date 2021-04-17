<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationProvince extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function municipality()
    {
        return $this->hasMany('App\Models\LocationMunicipality', 'province_id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'region_id', 'id');
    }

    public function address()
    {
        return $this->hasMany('App\Models\AgencyAddress', 'province_id');
    }
}
