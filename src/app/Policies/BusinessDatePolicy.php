<?php

namespace App\Policies;

use App\Models\{
    User,
    RouteActionTarget,
    Store
};
use App\Repositories\{
    RoleRepository\RoleRepositoryInterface
};

class BusinessDatePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(
        public readonly RoleRepositoryInterface $roleRepo,
    )
    {}

    /**
     * Determine whether the user can create models.
     * create
     * store
     */
    public function create(User $user, Store $store, int $storeId): bool
    {
        // 現在表示中のストアダッシュボードのストアIDと編集対象のストアIDが一致しているか
        if ($store->id !== $storeId) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['OPENINGPREPARATION_CREATE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['OPENINGPREPARATION_CREATE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }
}
