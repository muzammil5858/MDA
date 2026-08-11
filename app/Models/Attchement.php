<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attchement extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'alternate_allotment',
        'complete_property_file', 'adjacent_area_allotment', 'division_of_plots',
        'decision_courts', 'decision_allotment_committee',
        'decision_mda_board', 'decision_revising_authority',
'status',
        'entry_date','complete_file_pages',
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
