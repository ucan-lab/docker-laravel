<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRole extends Model
{
    use HasFactory;

    protected $table = 'group_role';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
