<?php
// app/Models/PlotHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlotHistory extends Model
{
    use HasFactory;

    protected $table = 'plot_histories';

    protected $fillable = [
        'property_id',
        'name',
        'father_name',
        'id_card',
        'challan_no',
        'address',        // New field
        'allottee_date',  // New field
        'transfer_order_no',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
