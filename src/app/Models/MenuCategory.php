<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sys_menu_category_id',
        'store_id',
        'name',
        'code',
        'order',
    ];

    public function sysMenuCategory()
    {
        return $this->belongsTo(SysMenuCategory::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
