<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'request_id',
        'document_type',
        'file_path',
        'remarks',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function request()
    {
        return $this->belongsTo(Requests::class);
    }
}
