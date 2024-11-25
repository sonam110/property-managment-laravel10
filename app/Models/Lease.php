<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;
class Lease extends Model
{
     protected $fillable = [
        'unique_id',
        'user_id',
        'property_id',
        'tenant_id',
        'unit_ids',
        'start_date',
        'due_on',
        'total_square',
        'price',
        'cam_price',
        'fixed_price',
        'camp_fixed_price',
        'square_foot',
        'end_month',
        'cam_square_foot',
        'camp_price',
        'total_rent',
        'total_cam',
        'load_taken',
        'lease_invoice_type',
    ];

     public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
    public function unit() {
        
        return $this->belongsTo(PropertyUnit::class, 'unit_ids');
    }
     public function partnetShare()
    {
        return $this->hasMany(PropertyPaymentSetting::class, 'tenant_id', 'id');
    }
    
}
