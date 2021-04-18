<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralSample extends Model
{
    use HasFactory;

    public function sampletype()
    {
        return $this->belongsTo('App\Models\ListSampleTest', 'sampletype_id', 'id');
    }

    public function analyses()
    {
        return $this->hasMany('App\Models\RequestAnalysis', 'sample_id');
    }

    public function referralanalyses()
    {
        return $this->hasMany('App\Models\ReferralAnalysis', 'sample_id');
    }


    public function package()
    {
        return $this->hasMany('App\Models\RequestSamplePackage', 'sample_id');
    }

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'request_id', 'id');
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
