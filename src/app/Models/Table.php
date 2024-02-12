<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    const DISPLAY = [
        'TRUE' => 1,
        'FALSE' => 0
    ];

    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'name',
        'display',
    ];

    public function store()
    {
        return $this->BelongsTo(Store::class);
    }

    public function bills()
    {
        return $this->belongsToMany(Bill::class);
    }
}
