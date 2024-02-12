<?php

namespace App\Repositories\SysPaymentMethodCategoryRepository;

use Illuminate\Support\Collection;
use App\Models\{
    SysPaymentMethodCategory,
    Store
};

interface SysPaymentMethodCategoryRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * システム支払い方法一覧を取得
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getSysPaymentMethodCategories($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/
}
