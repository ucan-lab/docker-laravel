<?php

namespace App\Repositories\SysPaymentMethodCategoryRepository;

use App\Models\{
    SysPaymentMethodCategory,
};
use Illuminate\Support\Collection;

class SysPaymentMethodCategoryRepository implements SysPaymentMethodCategoryRepositoryInterface
{
    private $model;

    public function __construct(SysPaymentMethodCategory $sysPaymentMethodCategory)
    {
        $this->model = $sysPaymentMethodCategory;
    }

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
    public function getSysPaymentMethodCategories($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->model
            ->orderBy($orderBy, $sortBy)
            ->get($columns);
    }

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
