<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\TransferFile;

class Requests extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function transfer()
    {
        return $this->hasOne(TransferFile::class, 'request_id', 'id');
    }
    public function attachment()
    {

        return $this->hasOne(Attchement::class, 'property_id', 'property_id');
    }
    public function propertyowner()
{
        return $this->hasOne(
            Inheritance::class,
            'property_id',
            'property_id',

        ) ->where('is_current', 1);
}

public function dummyreceiver(){
    return $this->hasMany(DummyReceiver::class, 'request_id', 'id');
}
public function dummywitness(){
    return $this->hasMany(DummyWitness::class, 'request_id', 'id');
}

public function witness(){
    return $this->hasMany(Witness::class, 'request_id', 'id');
}
public function participants()
    {
        return $this->hasMany(RequestParticipents::class, 'request_id', 'id');
    }

     public function transferAttaches()
    {
        return $this->hasOne(TransferAttach::class, 'request_id', 'id');
    }

    public function documents()
{
    return $this->hasOne(PropertyDocument::class, 'request_id');
}

public function requestGenerationOwner()
{
        return $this->hasMany(Inheritance::class,'request_id','id');
}

public function statement()
{

    return $this->hasOne(PropertyStatement::class, 'request_id');
}

public function smallRequest()
{
    return $this->hasOne(SmallRequest::class, 'request_id');
}
// Inside App\Models\Requests.php

public function Objections()
{
    return $this->hasMany(Objection::class);
}

/**
 * Helper to check if there is any pending objection
 */
public function deoObjections(){
    return $this->hasMany(Objection::class, 'requests_id')
                ->where('raised_by_role', 'record-clerk'); // adjust column to match yours
}

public function hasDeoPendingObjections()
{
    return $this->objections()->where('status', 'pending')->where('raised_by_role','record-clerk')->exists();
}

public function engineerObjections()
{
    return $this->hasMany(Objection::class, 'requests_id')
                ->where('raised_by_role', 'sub-engineer'); // adjust column to match yours
}
public function hdmObjections()
{
    return $this->hasMany(Objection::class, 'requests_id')
                ->where('raised_by_role', 'sub-engineer'); // adjust column to match yours
}
public function hasEngineerPendingObjections()
{
    return $this->objections()->where('status', 'pending')->where('raised_by_role','sub-engineer')->exists();
}

  public function mapApprovals()
{
    return $this->hasMany(MapApproval::class, 'request_id');
}

}
