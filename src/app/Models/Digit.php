<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Digit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'digit',
    ];

    const DECIMAL = ['id' => 1, 'digit' => '小数点以下', 'round' => 0, 'ceil' => 1, 'floor' => 1, 'js_digit' => 1];
    const ONE     = ['id' => 2, 'digit' => '一の位', 'round' => -1, 'ceil' => 10, 'floor' => 10, 'js_digit' => 10];
    const TEN     = ['id' => 3, 'digit' => '十の位', 'round' => -2, 'ceil' => 100, 'floor' => 100, 'js_digit' => 100];
    const HUNDRED = ['id' => 4, 'digit' => '百の位', 'round' => -3, 'ceil' => 1000, 'floor' => 1000, 'js_digit' => 1000];

    public static function getAllDigits() {
        return [
            self::DECIMAL,
            self::ONE,
            self::TEN,
            self::HUNDRED,
        ];
    }

    public static function getDigitById($id) {
        foreach (self::getAllDigits() as $digit) {
            if ($digit['id'] === $id) {
                return $digit;
            }
        }
        return null;
    }

}
