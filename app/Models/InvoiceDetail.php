<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $fillable = [
        'invoice_id',
        'random_id',
        'item_desc',
        'quantity',
        'rate',
        'amount',
        'sub_total',
        'type',
        'item_type',
        'partner_share',
        'term',
    ];
}
