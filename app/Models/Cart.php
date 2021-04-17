<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $with = ['cartable'];
    public $timestamps = false;
    protected $fillable = ['subtotal','discount','total','type','transaction_id'];

    public function cartable()
    {
        return $this->morphTo();
    }

    public function request()
    {
        return $this->morphTo('request');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\FinanceTransaction', 'transaction_id', 'id');
    }
}
