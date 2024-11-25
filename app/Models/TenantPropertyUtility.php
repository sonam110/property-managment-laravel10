<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantPropertyUtility extends Model
{
    protected $fillable = [
        'property_id',
        'bill_date',
        'energy_charge',
        'fppas',
        'energy_duty',
        'tod_net_sum',
        'energy_charge_as_per_bill',
        'total_units',
        'tenants_units',
        'tod_rebate_charge',
        'per_unit_charge',
        'total_tenant_units',
        'unit_lost',
        'energy_losses',
        'energy_losses_per_tenant_unit',
        'energy_unit_per_unit',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
}
