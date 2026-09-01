<?php

namespace App\Models;

use App\Models\Attchement;
use App\Models\Sector;
use App\Models\CurrentOwner;
use App\Models\Payment;
use App\Models\PlotHistory;
use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'properties';

    // Relationship with CurrentOwner
    public function currentOwners()
    {
        return $this->hasMany(CurrentOwner::class, 'property_id');
    }

    // Property Model mein\
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    // Property Model
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'property_id');
    }

    public function plotHistories()
    {
        return $this->hasMany(PlotHistory::class, 'property_id');
    }

    public function attachment()
    {
        return $this->hasOne(Attchement::class, 'property_id');
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }
}
