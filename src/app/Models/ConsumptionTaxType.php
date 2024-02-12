<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionTaxType extends Model
{
    use HasFactory;

    const INTERNAL_TAX = ['id' => 1, 'type' => '内税'];
    const EXTERNAL_TAX = ['id' => 2, 'type' => '外税'];
    
    public static function getAllTypes() {
        return [
            self::INTERNAL_TAX,
            self::EXTERNAL_TAX,
        ];
    }
    
    public static function getTypeById($id) {
        foreach (self::getAllTypes() as $type) {
            if ($type['id'] === $id) {
                return $type;
            }
        }
        return null;
    }
}
