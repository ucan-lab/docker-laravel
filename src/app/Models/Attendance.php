<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_date_id',
        'working_start_at',
        'working_end_at',
        'break_total_minute',
        'late_total_minute',
        'absence',
        'unauthorized_absence',
        'payment_amount',
        'payment_type',
        'payment_source',
    ];

    const PAYMENT_TYPE = [
        'FULL_DAY' => 'full_day',
        'ADVANCE' => 'advance'
    ];

    const PAYMENT_SOURCE = [
        'CASH_REGISTER' => 'cash_register',
        'OTHER' => 'other'
    ];

    public function businessDate()
    {
        return $this->belongsTo(BusinessDate::class);
    }
}
