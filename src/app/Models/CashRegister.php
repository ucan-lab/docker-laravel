<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_date_id',
        'cash_at_opening',
        'ten_thousand',
        'five_thousand',
        'two_thousand',
        'one_thousand',
        'five_hundred',
        'hundred',
        'fifty',
        'ten',
        'five',
        'one',
        'memo',
    ];
}
