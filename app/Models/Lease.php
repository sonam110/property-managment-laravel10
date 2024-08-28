<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
    public function blacklists()
    {
        return $this->hasMany(Blacklist::class, 'create_by', 'id');
    }
}
