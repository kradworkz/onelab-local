<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'fee', 'sampletype_id'
     ];

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }
   
    public function sample()
    {
        return $this->hasMany('App\Models\RequestSamplePackage', 'package_id');
    }

    public function sampletype()
    {
        return $this->belongsTo('App\Models\ListSampleTest', 'sampletype_id', 'id');
    }
    
    public function lists()
    {
        return $this->hasMany('App\Models\ListPackageList', 'package_id');
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
