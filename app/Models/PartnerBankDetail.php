<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerBankDetail extends Model
{
    protected $fillable = [
        'user_id',
        'bank_se_name',
        'bank_name',
        'account_holder_name',
        'account_no',
        'bank_ifsc_code',
        'bank_address',
        'for_type',
     ];
}
