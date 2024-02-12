<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModifiedOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'modified_amount',
        'modified_is_service_included',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
