<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemizedSetOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'itemized_order_id',
        'start_at',
        'end_at',
    ];

    public function itemizedOrder()
    {
        return $this->belongsTo(ItemizedOrder::class);
    }
}
