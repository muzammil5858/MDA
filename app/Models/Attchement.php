<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attchement extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'alternate_allotment',
         'property_document',  'adjacent_area_allotment', 'allotment_order',
        'decision_courts', 'decision_allotment_committee',
        'decision_mda_board', 'decision_revising_authority',
'status',
        'entry_date','complete_file_pages',
         'noting_file',               // New field
        'cnic_front',
    ];

        // Add this mutator to automatically cast entry_date to Carbon
    protected $casts = [
        'entry_date' => 'datetime',
        'status' => 'boolean',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
