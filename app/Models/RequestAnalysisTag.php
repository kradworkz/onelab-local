<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAnalysisTag extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['start','end','user_id','analysis_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function analysis()
    {
        return $this->belongsTo('App\Models\RequestAnalysis', 'analysis_id', 'id');
    }

    public function getStartAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getEndAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
