<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferFile extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function attachment()
    {
        return $this->hasOne(Attchement::class, 'property_id', 'property_id');
    }
     public function callRepresentative()
    {
        return $this->belongsTo(Representative::class, 'representative_id');
    }
     public function callAttorney()
    {
        return $this->belongsTo(Representative::class, 'shared_attorney_id');
    }
    public function callSharedRepresentative()
    {
        return $this->belongsTo(Representative::class, 'shared_representative_id');
    }   
}
