<?php

namespace App\Repositories\BusinessDateRepository;

use App\Models\{
    BusinessDate,
    Store
};
use Illuminate\Support\Collection;

class BusinessDateRepository implements BusinessDateRepositoryInterface
{
    private $model;

    public function __construct(BusinessDate $businessDate)
    {
        $this->model = $businessDate;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 営業日付を登録する
     * @param array $data
     * @return BusinessDate
     */
    public function createBusinessDate(array $data): BusinessDate
    {
        // opening_timeを現在時刻で設定
        $data['opening_time'] = now();
        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 営業日付を取得する
     * @param int $id
     * @return BusinessDate
     */
    public function findBusinessDate(int $id): BusinessDate
    {
        return $this->model->findOrFail($id);
    }

    /**
     * 現在の営業日付を取得
     * @param Store $store
     * @return ?BusinessDate
     */
    public function getCurrentBusinessDate(Store $store): ?BusinessDate
    {
        return $this->model->where('store_id', $store->id)
            ->where('closing_time', null)
            ->first();
    }

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
    public function updateBusinessDate(int $id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/
}
