<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectionAttachement extends Model
{
    use HasFactory;
    protected $table = 'objection_attachments';
    protected $fillable = [
        'objection_response_id',
        'file_path',
        'file_name',
        'document_type',
        'status',
        'action_by_id'
    ];

    // Link back to the parent response
    public function response()
    {
        return $this->belongsTo(ObjectionResponse::class, 'objection_response_id');
    }
}
