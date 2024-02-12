<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    const TARGETS = [
        'SELF' => ['id' => 1, 'target' => 'self'],
        'STORE' => ['id' => 2, 'target' => 'store'],
        'GROUP' => ['id' => 3, 'target' => 'group'],
    ];

    public static function getTargetById($id) {
        foreach (self::TARGETS as $target) {
            if ($target['id'] === $id) {
                return $target;
            }
        }
        return null;
    }

}
