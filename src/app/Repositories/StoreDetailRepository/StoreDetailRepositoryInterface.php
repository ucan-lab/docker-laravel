<?php

namespace App\Repositories\StoreDetailRepository;

use Illuminate\Support\Carbon;
use App\Models\{
    StoreDetail,
    Store
};
use Illuminate\Support\Collection;

interface StoreDetailRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 店舗詳細を作成する
     * @param Store $store Storeモデル
     * @param array $data 店舗詳細作成に必要なデータ
     * @return StoreDetail 作成された店舗詳細
     */
    public function createStoreDetail(Store $store, array $data): StoreDetail;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 引数.最新の店舗詳細を取得する
     * @param Store $store
     * @return StoreDetail
     */
    public function getLatestStoreDetail(Store $store);

    /**
     * 引数.最新以外の店舗詳細を取得する
     * @param Store $store
     * @return Collection
     */
    public function getNonEffectiveStoreDetails(Store $store): Collection;

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
