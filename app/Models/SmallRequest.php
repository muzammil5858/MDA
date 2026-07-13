<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class SmallRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'request_id',
        'architect_name',
        'architect_address',
        'architect_stamp_signature',
        'engineer_name',
        'engineer_address',
        'engineer_stamp_signature',
        'area_per_sqft',
        'total_amount',
        'representation_type',
        'attorney_name',
        'attorney_father_name',
        'attorney_cnic',
        'attorney_address',
        'attorney_cnic_front',
        'attorney_cnic_back',
        'attorney_letter',
        'approved_map',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
