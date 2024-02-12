<?php

namespace App\Services\StoreService;
use App\Models\{
    Store,
};

interface StoreServiceInterface
{
    /**
     * 店舗を作成する
     * @param array $store
     * @param array $storeDetail
     * @return Store
     */
    public function createStore(array $store, array $storeDetail): Store;
}
