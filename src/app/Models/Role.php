<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    public function routeActionTargets(): BelongsToMany
    {
        return $this->belongsToMany(RouteActionTarget::class)->withTimestamps();
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_role')->withTimestamps();
    }

    public function defaultGroupRole()
    {
        return $this->hasOne(DefaultGroupRole::class);
    }

    public function defaultStoreRole()
    {
        return $this->hasOne(DefaultStoreRole::class);
    }

    public function groupRoles()
    {
        return $this->hasMany(GroupRole::class);
    }
}
