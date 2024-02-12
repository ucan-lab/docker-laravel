<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysMenuCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
    ];
    const CATEGORIES = [
        'FIRST_SET' => ['id' => 1, 'category' => '初回セット'],
        'EXTENSION_SET' => ['id' => 2, 'category' => '延長セット'],
        'SELECTION' => ['id' => 3, 'category' => '指名'],
        'DRINK_FOOD' => ['id' => 4, 'category' => '飲食']
    ];

    public static function getById($id) {
        foreach (self::CATEGORIES as $target) {
            if ($target['id'] === $id) {
                return $target;
            }
        }
        return null;
    }

}
