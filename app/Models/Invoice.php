<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
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
     public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id', 'id');
    }
    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id', 'id');
    }

}
