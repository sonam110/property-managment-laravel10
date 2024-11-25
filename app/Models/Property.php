<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    
   	public function units()
    {
        return $this->hasMany(PropertyUnit::class,'property_id', 'id');
    }
    public function invoice()
    {
        return $this->hasMany(Invoice::class,'property_id', 'id');
    }
    public function lease()
    {
        return $this->hasMany(Lease::class,'property_id', 'id');
    }
}
