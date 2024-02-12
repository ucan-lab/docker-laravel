<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'itemized_order_id',
        'menu_id',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function itemizedOrder()
    {
        return $this->belongsTo(ItemizedOrder::class);
    }

    public function userIncentive()
    {
        return $this->hasOne(UserIncentive::class);
    }

    public function selectionOrder()
    {
        return $this->hasOne(SelectionOrder::class);
    }

    public function modifiedOrders()
    {
        return $this->hasMany(ModifiedOrder::class);
    }
}
