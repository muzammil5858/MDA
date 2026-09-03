<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $table = 'blocks';

    protected $fillable = [
        'name',
        'sector_id',
    ];

    /**
     * Get the sector that owns the block.
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    /**
     * Get the properties for the block.
     */
    public function properties()
    {
        return $this->hasMany(Property::class, 'block_id');
    }
}
