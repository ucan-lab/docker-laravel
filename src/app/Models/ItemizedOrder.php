<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemizedOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function itemizedSetOrder()
    {
        return $this->hasOne(ItemizedSetOrder::class);
    }
}
