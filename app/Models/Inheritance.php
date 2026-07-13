<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inheritance extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function property(){
        return $this->hasOne(Property::class, 'id','property_id');
    }
    public function biometric()
    {
        return $this->belongsTo(Biometric::class, 'biometric_id');
    }
}
