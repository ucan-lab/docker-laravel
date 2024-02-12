<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralUser extends Model
{
    const LOGIN_ALLOW = ['id' => 1, 'can_login' => true];
    const LOGIN_DENY = ['id' => 2, 'can_login' => false];

    public static function getAll() {
        return [
            self::LOGIN_ALLOW,
            self::LOGIN_DENY,
        ];
    }

    public static function getById($id) {
        foreach (self::getAll() as $unit) {
            if ($unit['id'] == $id) {
                return $unit;
            }
        }
        return null;
    }

    /**
     * canLoginから定数を返す
     * @param boolean $canLogin
     */
    public static function getByCanLogin($canLogin) {
        foreach (self::getAll() as $unit) {
            if ($unit['can_login'] == $canLogin) {
                return $unit;
            }
        }
        return null;
    }


    use HasFactory;

    protected $fillable = [
        'user_id',
        'can_login',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
