<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_id',
        'property_id',
        'drawing_no',
        'drawing_date',
        'drawing_location',
        'allocated_area',
        'road_location',
        'construction_status',
        'plot_size_status',
        'added_area_sq_yards',
        'additional_remarks',
        'impact_on_public',
        'graveyard_status',
        'separate_plot',
        'tor_compliance',
        'existing_condition',
        'status',
        'remarks',
    ];

    protected $casts = [
        'drawing_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function request()
    {
        return $this->belongsTo(Requests::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

  
}
