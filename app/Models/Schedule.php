<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $table ='schedules';
    protected $guarded = [];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function hasMaxAppointments()
    {
        return $this->appointments()->count() >= 4;
    }
}
