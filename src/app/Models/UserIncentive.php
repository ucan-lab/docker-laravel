<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserIncentive extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'user_id',
        'amount'
    ];

    const INCENTIVE_TARGET = [
        'NONE' => ['id' => 0, 'type' => 1, 'display_name' => 'バック先なし'],
        'USER' => ['type' => 2],
        'SELECTION' => ['type' => 3],
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
