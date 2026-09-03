<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'sectors';

    protected $fillable = [
        'name',
        // add other fields if needed
    ];

    /**
     * Get the blocks for the sector.
     */
    public function blocks()
    {
        return $this->hasMany(Block::class, 'sector_id');
    }

    /**
     * Get the properties for the sector.
     */
    public function properties()
    {
        return $this->hasMany(Property::class, 'sector_id');
    }
}
