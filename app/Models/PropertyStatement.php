<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyStatement extends Model
{
    protected $fillable = [
        'request_id',
        'property_id',
        'requester_statement',
        'receiver_statement',
        'transfer_order',
        'nakle_bala',
        'witness_statement',
    ];

    /**
     * Get the request associated with the statement.
     */
    public function request(): BelongsTo
    {
        return $this->belongsTo(Requests::class, 'request_id');
    }

}
