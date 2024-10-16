<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyUnit extends Model
{
     protected $fillable = [
        'property_id ',
        'property_code',
        'unit_type',
        'unit_name',
        'total_square',
        'price',
        'cam_price',
        'unit_name_prefix',
        'unit_floor',
        'total_shop',
        'is_rented',
    ];
}
