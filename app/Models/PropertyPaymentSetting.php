<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyPaymentSetting extends Model
{
    use HasFactory;
    public function partner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
