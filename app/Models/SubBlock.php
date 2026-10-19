<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubBlock extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'block_id'];

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }
}
