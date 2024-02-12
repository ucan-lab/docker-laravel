<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysPaymentMethodCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    const SYS_PAYMENT_METHOD_CATEGORIES = [
        'CASH' => ['id' => 1, 'name' => '現金'],
        'OTHER' => ['id' => 2, 'name' => 'その他'],
    ];
}
