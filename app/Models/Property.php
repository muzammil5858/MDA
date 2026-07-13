<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attchement;
use App\Models\Town;

class Property extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function attachment()
    {
        return $this->hasOne(Attchement::class, 'property_id');
    }
    public function township()
    {
        return $this->belongsTo(Town::class, 'town', 'id');
    }
    public function owners()
    {
        return $this->hasMany(Inheritance::class, 'property_id', 'id')
                ->where('is_current', 1);
    }
    public function oldowners(){
        return $this->hasMany(Inheritance::class, 'property_id', 'id')
            ->where(function ($query) {
                $query->whereNull('request_id')
                      ->orWhere('request_id', 0);
            });
    }
    
}
