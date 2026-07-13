<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferAttach extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function request()
{
    return $this->belongsTo(Requests::class, 'request_id', 'id');
}

}
