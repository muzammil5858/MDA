<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlotHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'name', 'id_card', 'challan_no',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
