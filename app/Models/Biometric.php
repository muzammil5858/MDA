<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biometric extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function inheritance()
    {
        return $this->hasOne(Inheritance::class, 'biometric_id');
    }
}
