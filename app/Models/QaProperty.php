<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QaProperty extends Model
{
    use HasFactory;

    // Agar table ka naam different hai toh specify karein
    protected $table = 'qa_properties'; // Default yehi hai

    protected $fillable = ['property_id', 'user_id', 'status', 'issue', 'remarks'];

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
