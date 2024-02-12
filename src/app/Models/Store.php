<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'image_path',
        'address',
        'postal_code',
        'tel_number',
        'opening_time',
        'closing_time',
        'working_time_unit_id',
    ];

    public function storeDetails()
    {
        return $this->hasMany(StoreDetail::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'store_role')->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsTo(Group::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function menuCategories()
    {
        return $this->hasMany(MenuCategory::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }
}
