<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectionOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'itemized_set_order_id',
        'order_id',
        'user_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
