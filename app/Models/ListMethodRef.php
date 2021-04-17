<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMethodRef extends Model
{
    use HasFactory;

    public function laboratory()
    {
        return $this->belongsTo('App\Models\DropdownList', 'laboratory_id', 'id');
    }

    public function method()
    {
        return $this->hasMany('App\Models\ListTestService', 'method_id');
    }

    public function reference()
    {
        return $this->hasMany('App\Models\ListTestService', 'reference_id');
    }
}
