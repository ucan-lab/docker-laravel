<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreRole extends Model
{
    use HasFactory;

    protected $table = 'store_role';

    public function users()
    {
        return $this->belongsToMany(User::class, 'store_role_user', 'store_role_id', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
