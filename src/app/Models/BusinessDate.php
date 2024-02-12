<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'business_date',
        'opening_time',
        'closing_time',
    ];

    public function cashRegister()
    {
        return $this->hasOne(CashRegister::class);
    }
}
