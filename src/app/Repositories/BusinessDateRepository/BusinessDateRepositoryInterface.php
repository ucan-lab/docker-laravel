<?php

namespace App\Repositories\BusinessDateRepository;

use Illuminate\Support\Collection;
use App\Models\{
    BusinessDate,
    Store
};

interface BusinessDateRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 営業日付を登録する
     * @param array $data
     * @return BusinessDate
     */
    public function createBusinessDate(array $data): BusinessDate;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 営業日付を取得する
     * @param int $id
     * @return BusinessDate
     */
    public function findBusinessDate(int $id): BusinessDate;

    /**
     * 現在の営業日付を取得
     * @param Store $store
     * @return ?BusinessDate
     */
    public function getCurrentBusinessDate(Store $store): ?BusinessDate;

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * 指定IDのレコードを更新する
     * @param int $id
     * @param array $data
     *
     * @return bool
     */
    public function updateBusinessDate(int $id, array $data): bool;

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/
}
