<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;
class Tenant extends Model
{
    use HasFactory;
    public function role()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
}
