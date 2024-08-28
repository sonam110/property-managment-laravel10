<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaseExtraCharge extends Model
{
    use HasFactory;
    public function extraCharge()
    {
        return $this->belongsTo(ExtraCharge::class, 'extra_charge_id', 'id');
    }
}
