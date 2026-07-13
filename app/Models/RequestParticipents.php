<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inheritance;

class RequestParticipents extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function owner()
{
    return $this->belongsTo(Inheritance::class, 'owner_id');
}
    public function representative()
{
    return $this->belongsTo(Representative::class, 'representative_id');
}

}
