<?php

namespace App\Services\StoreSalesService;

use App\Models\{
    Store,
    BusinessDate
};

interface StoreSalesServiceInterface
{
    /**
     * @param Store $store
     * @param BusinessDate $businessDate
     *
     */
    public function getBusinessDayReport(Store $store, BusinessDate $businessDate);
}
