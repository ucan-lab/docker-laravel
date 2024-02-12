<?php

namespace App\Services\StoreService;

use App\Services\StoreService\StoreServiceInterface;
use App\Models\{
    Store,
    RouteActionTarget,
    Table,
};
use App\Repositories\{
    StoreRepository\StoreRepositoryInterface,
    StoreDetailRepository\StoreDetailRepositoryInterface,
    RoleRepository\RoleRepositoryInterface,
    TableRepository\TableRepositoryInterface,
};

class StoreService implements StoreServiceInterface
{

    const DUMMY = [
        'TABLES' => [
            ['name' => '1卓', 'display' => Table::DISPLAY['TRUE']],
            ['name' => '2卓', 'display' => Table::DISPLAY['TRUE']],
            ['name' => '6卓', 'display' => Table::DISPLAY['TRUE']],
            ['name' => '3卓', 'display' => Table::DISPLAY['TRUE']],
            ['name' => '4卓', 'display' => Table::DISPLAY['TRUE']],
            ['name' => '5卓', 'display' => Table::DISPLAY['TRUE']],
        ]
    ];


    public function __construct(
        public readonly StoreRepositoryInterface $storeRepo,
        public readonly StoreDetailRepositoryInterface $storeDetailRepo,
        public readonly RoleRepositoryInterface $roleRepo,
        public readonly TableRepositoryInterface $tableRepo,
    ) {
    }

    /**
     * 店舗を作成する
     * @param array $store
     * @param array $storeDetail
     * @return Store
     */
    public function createStore(array $store, array $storeDetail): Store
    {
        // 店舗作成
        $createdStore = $this->storeRepo->createStore($store);

        // 店舗詳細作成
        $storeDetail = $this->storeDetailRepo->createStoreDetail($createdStore, $storeDetail);

        // デフォルトストラロール一覧をストアに付与
        $defaultRoles = $this->roleRepo->getAllDefaultStoreRoles();
        $defaultRoleIds = $defaultRoles->pluck("id")->toArray();
        $this->roleRepo->attachRolesToStore($defaultRoleIds, $createdStore);

        // ダミー卓を設定
        foreach ($this::DUMMY['TABLES'] as $table) {
            $table['store_id'] = $createdStore->id;
            $this->tableRepo->createTable($table);
        }

        return $createdStore;
    }
}
