<?php

namespace App\Repositories\StoreRepository;

use App\Models\{
    Store,
    Group,
    User,
};
use Illuminate\Support\Collection;

interface StoreRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 店舗を作成する
     * @param array $data 店舗作成に必要なデータ
     * @return Store 作成された店舗
     */
    public function createStore(array $data): Store;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * グループに属する店舗一覧を取得
     * @param Group $group
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getStoreListByGroup(Group $group, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    /**
     * ユーザーの所属店舗を取得する
     * @param User $user
     * @return Collection
     */
    public function getUserStores(User $user): Collection;

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * 店舗を更新する
     * @param Store $store 元データ
     * @param array $params 更新データ
     * @return bool
     */
    public function updateStore(Store $store, array $params): bool;

    /***********************************************************
     * Delete系
     ***********************************************************/


    /***********************************************************
     * その他
     ***********************************************************/






}
