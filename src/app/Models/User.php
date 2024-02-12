<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'display_name',
        'email',
        'password',
        'icon_img',
        'real_name',
        'tel_number',
        'birth_day',
        'postal_code',
        'address',
        'note',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function contractUser()
    {
        return $this->hasOne(ContractUser::class);
    }

    public function generalUser()
    {
        return $this->hasOne(GeneralUser::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user')->withTimestamps();
    }

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'store_user')->withTimestamps();
    }

    public function groupRoles()
    {
        return $this->belongsToMany(GroupRole::class, 'group_role_user');
    }

    public function storeRoles()
    {
        return $this->belongsToMany(StoreRole::class, 'store_role_user');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
