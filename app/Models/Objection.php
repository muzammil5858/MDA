<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;

    protected $fillable = [
        'requests_id',
        'raised_by_id',
        'raised_by_role',
        'objection_type',
        'remarks',
        'status',
        'objection_date'
    ];

    // Link to the Property/Request this objection belongs to
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Link to the Official who raised the objection
    public function raisedBy()
    {
        return $this->belongsTo(User::class, 'raised_by_id');
    }

    // Get all responses/replies for this specific objection
    public function responses()
    {
        return $this->hasMany(ObjectionResponse::class);
    }

    // Get the latest user response (for backward compatibility and quick access)
    public function getUserResponseAttribute()
    {
        return $this->responses()->latest()->first();
    }
}
