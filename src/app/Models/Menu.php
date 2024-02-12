<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    const DISPLAY = [
        'TRUE' => 1,
        'FALSE' => 0
    ];

    protected $fillable = [
        'menu_category_id',
        'name',
        'price',
        'insentive_persentage',
        'insentive_amount',
        'code',
        'order',
        'display',
    ];

    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function setMenu()
    {
        return $this->hasOne(SetMenu::class);
    }
}
