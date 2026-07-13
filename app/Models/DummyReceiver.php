<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DummyReceiver extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function request()
{
    return $this->belongsTo(Requests::class, 'request_id', 'id');
}
    public function representative()
    {
        return $this->hasOne(Representative::class, 'id', 'representative_id');
    }


}
