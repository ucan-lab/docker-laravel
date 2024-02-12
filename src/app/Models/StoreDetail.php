<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreDetail extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'store_id',
        'invoice_registration_number',
        'service_rate',
        'service_rate_digit_id',
        'service_rate_rounding_method_id',
        'consumption_tax_rate',
        'consumption_tax_rate_digit_id',
        'consumption_tax_rate_rounding_method_id',
        'consumption_tax_type_id',
        'user_incentive_digit_id',
        'user_incentive_rounding_method_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }


}
