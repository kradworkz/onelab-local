<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTestService extends Model
{
    use HasFactory;

    public function analysis()
    {
        return $this->hasMany('App\Models\RequestAnalysis', 'testservice_id');
    }

    public function referralanalysis()
    {
        return $this->hasMany('App\Models\ReferralAnalysis', 'testservice_id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function sampletype()
    {
        return $this->belongsTo('App\Models\ListSampleTest', 'sampletype_id', 'id');
    }

    public function testname()
    {
        return $this->belongsTo('App\Models\ListSampleTest', 'testname_id', 'id');
    }

    public function method()
    {
        return $this->belongsTo('App\Models\ListMethodRef', 'method_id', 'id');
    }

    public function reference()
    {
        return $this->belongsTo('App\Models\ListMethodRef', 'reference_id', 'id');
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
