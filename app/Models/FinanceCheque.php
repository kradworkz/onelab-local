<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceCheque extends Model
{
    use HasFactory;

    public function transaction()
    {
        return $this->belongsTo('App\Models\FinanceTransaction', 'transaction_id', 'id');
    }

    public function getChequeDateAttribute($value)
    {
        return date('F d, Y', strtotime($value));
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
