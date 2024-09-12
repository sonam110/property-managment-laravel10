<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantContactInfo extends Model
{
    use HasFactory;
    public function tenantInfo()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
}
