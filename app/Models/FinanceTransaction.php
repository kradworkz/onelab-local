<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_no','status','customer_id','payment_id','collection_id'];

    public function receipt()
    {
        return $this->hasOne('App\Models\FinanceReceipt', 'transaction_id');
    }

    public function cheque()
    {
        return $this->hasOne('App\Models\FinanceCheque', 'transaction_id');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart', 'transaction_id');
    }

    public function info()
    {
        return $this->hasMany('App\Models\FinanceTransactionInfo', 'transaction_id');
    }

    public function payment()
    {
        return $this->belongsTo('App\Models\DropdownList', 'payment_id', 'id');
    }

    public function collection()
    {
        return $this->belongsTo('App\Models\DropdownList', 'collection_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Address', 'customer_id', 'id');
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
