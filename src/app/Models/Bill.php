<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_date_id',
        'store_id',
        'arrival_time',
        'departure_time',
        'store_detail_id',
        'service_rate',
        'consumption_tax_rate',
        'discount_amount',
        'discount_note',
        'receipt_issued',
        'invoice_issued',
        'memo',
    ];

    const ISSUED_STATUS = [
        'HAS_ISSUED' => true,
        'HAS_NOT_ISSUED' => false
    ];


    public function businessDate()
    {
        return $this->belongsTo(BusinessDate::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function tables()
    {
        return $this->belongsToMany(Table::class);
    }

    public function itemizedOrders()
    {
        return $this->hasMany(ItemizedOrder::class);
    }

    public function numberOfCustomer()
    {
        return $this->hasOne(NumberOfCustomer::class);
    }

    public function billPayments()
    {
        return $this->hasMany(BillPayment::class);
    }
}
