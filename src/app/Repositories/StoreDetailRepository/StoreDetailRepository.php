<?php

namespace App\Repositories\StoreDetailRepository;

use Illuminate\Support\Carbon;
use App\Repositories\StoreDetailRepository\StoreDetailRepositoryInterface;
use App\Models\{
    StoreDetail,
    Store
};
use Illuminate\Support\Collection;

class StoreDetailRepository implements StoreDetailRepositoryInterface
{
    public function __construct(StoreDetail $store)
    {
        $this->model = $store;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 店舗詳細を作成する
     * @param Store $store Storeモデル
     * @param array $data 店舗詳細作成に必要なデータ
     * @return StoreDetail 作成された店舗詳細
     */
    public function createStoreDetail(Store $store, array $data): StoreDetail
    {
        // store_idを付与
        $data['store_id'] = $store->id;

        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 引数.最新の店舗詳細を取得する
     * @param Store $store
     * @return StoreDetail
     */
    public function getLatestStoreDetail(Store $store)
    {
        return $this->model->where('store_id', $store->id)
            ->latest()
            ->first();
    }

    /**
     * 引数.最新以外の店舗詳細を取得する
     * @param Store $store
     * @return Collection
     */
    public function getNonEffectiveStoreDetails(Store $store): Collection
    {
        return $this->model->where('store_id', $store->id)
            ->whereNotIn('id', [$this->getLatestStoreDetail($store)->id])
            ->get();
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
