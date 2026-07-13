<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectionResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'objection_id',
        'user_id',
        'response_text',
        'attachment',
        'status',
        'authority_remarks',
    ];

    // Link back to the parent objection
    public function objection()
    {
        return $this->belongsTo(Objection::class);
    }

    // Link to the person who wrote the response (User or Officer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Link to any attachments related to this response
    public function attachments()
    {
        return $this->hasMany(ObjectionAttachement::class, 'objection_response_id');
    }
}
