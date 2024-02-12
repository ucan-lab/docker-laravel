<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingTimeUnit extends Model
{
    use HasFactory;

    const UNIT_1_MIN = ['id' => 1, 'minutes' => 1];
    const UNIT_5_MIN = ['id' => 2, 'minutes' => 5];
    const UNIT_10_MIN = ['id' => 3, 'minutes' => 10];
    const UNIT_15_MIN = ['id' => 4, 'minutes' => 15];
    const UNIT_30_MIN = ['id' => 5, 'minutes' => 30];
    const UNIT_60_MIN = ['id' => 6, 'minutes' => 60];

    public static function getAllUnits() {
        return [
            self::UNIT_1_MIN,
            self::UNIT_5_MIN,
            self::UNIT_10_MIN,
            self::UNIT_15_MIN,
            self::UNIT_30_MIN,
            self::UNIT_60_MIN,
        ];
    }

    public static function getUnitById($id) {
        foreach (self::getAllUnits() as $unit) {
            if ($unit['id'] === $id) {
                return $unit;
            }
        }
        return null;
    }
}
