<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoundingMethod extends Model
{
    use HasFactory;

    const ROUND_UP         = ['id' => 1, 'rounding_method' => '切り上げ', 'method' => 'ceil'];
    const ROUND_DOWN       = ['id' => 2, 'rounding_method' => '切り捨て', 'method' => 'floor'];
    const ROUND_TO_NEAREST = ['id' => 3, 'rounding_method' => '四捨五入', 'method' => 'round'];

    public static function getAllMethods() {
        return [
            self::ROUND_UP,
            self::ROUND_DOWN,
            self::ROUND_TO_NEAREST
        ];
    }

    public static function getRoundingMethodById($id) {
        foreach (self::getAllMethods() as $method) {
            if ($method['id'] === $id) {
                return $method;
            }
        }
        return null;
    }
}
