<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function biometric()
    {
        return $this->belongsTo(Biometric::class, 'biometric_id');
    }
}
