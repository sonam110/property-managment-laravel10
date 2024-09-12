<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

     public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id', 'id');
    }
   
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
}
