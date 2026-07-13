<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginBiometric extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'login_biometrics';

}
