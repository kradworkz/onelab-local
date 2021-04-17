<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceOrseries extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->belongsTo('App\Models\DropdownList', 'type_id', 'id');
    }

    public function receipt()
    {
        return $this->hasMany('App\Models\FinanceReceipt', 'orseries_id');
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
