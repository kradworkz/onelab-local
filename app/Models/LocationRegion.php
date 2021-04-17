<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationRegion extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function province()
    {
        return $this->hasMany('App\Models\LocationProvince', 'region_id');
    }
   
    public function address()
    {
        return $this->hasMany('App\Models\AgencyAddress', 'province_id');
    }
}
