<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'total_price', 'amount_deposited', 'remaining_amount', 'down_payment',
        'initial_notice_no', 'initial_notice_date',
        'total_received_amount', 'received_amount_date',
        'allotment_order_no', 'allotment_order_date',
        'possession_slip_no', 'possession_slip_date',
        'boundary_wall_approval', 'map_approval_date', 'transfer_order_no',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
