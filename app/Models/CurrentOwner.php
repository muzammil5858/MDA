<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentOwner extends Model
{
    use HasFactory;

    protected $table = 'current_owners';

    protected $fillable = [
        'property_id',
        'applicant_name',
        'father_husband_name',
        'old_nic',
        'cnic',
        'date_of_transfer',
        'address_temporary',
        'address_permanent',
        'transfer_order_no'
    ];

    // Relationship with Property
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
