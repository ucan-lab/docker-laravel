<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberOfCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'arrival',
        'join',
        'leave',
    ];
}
