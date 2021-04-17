<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestSamplePackage extends Model
{
    use HasFactory;

    protected $fillable = ['status','package_id','sample_id','fee','is_view'];

    public function sample()
    {
        return $this->belongsTo('App\Models\RequestSample', 'sample_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\ListPackage', 'package_id', 'id');
    }

}
