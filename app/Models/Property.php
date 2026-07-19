<?php

namespace App\Models;

use App\Models\Attchement;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table =  'properties';   
    // protected $fillable = [
    //     'application_no', 'application_date', 'plot_no', 'sector', 'block',
    //     'kanal', 'marla', 'sqrft', 'approved_scheme',
    //     'initial_draft_amount', 'initial_draft_date',
    //     'applicant_name', 'father_husband_name', 'old_nic', 'cnic',
    //     'address_temporary', 'address_permanent',
    //     'category', 'mode_allottment', 'allotment_date', 'balloting_serial_no',
    //     'user_id',
    // ];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function plotHistories()
    {
        return $this->hasMany(PlotHistory::class);
    }

    public function attachment()
    {
        return $this->hasOne(Attchement::class);
    }
}









// class Property extends Model
// {
//     use HasFactory;
//     protected $guarded = [];

//     public function attachment()
//     {
//         return $this->hasOne(Attchement::class, 'property_id');
//     }
//     public function township()
//     {
//         return $this->belongsTo(Sector::class, 'town', 'id');
//     }
//     public function owners()
//     {
//         return $this->hasMany(Inheritance::class, 'property_id', 'id')
//                 ->where('is_current', 1);
//     }
//     public function oldowners(){
//         return $this->hasMany(Inheritance::class, 'property_id', 'id')
//             ->where(function ($query) {
//                 $query->whereNull('request_id')
//                       ->orWhere('request_id', 0);
//             });
//     }

// }
