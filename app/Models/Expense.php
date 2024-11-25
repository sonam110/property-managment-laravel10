<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
   protected $fillable = [
        'id ',
        'property_id ',
        'price',
        'type',
        'ex_date',
        'description',
        'receipt',
        'note',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }
}
