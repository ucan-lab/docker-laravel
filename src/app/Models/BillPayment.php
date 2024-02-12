<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bill_id',
        'payment_method_id',
        'receipt_amount',
        'total_amount'
    ];
}
