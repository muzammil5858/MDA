<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyFieldEntry extends Model
{
    protected $fillable = [
        'property_id',
        'user_id',
        'entry_date',
        'fields_changed',
    ];

    protected $casts = [
        'fields_changed' => 'array',
        'entry_date'     => 'date',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
