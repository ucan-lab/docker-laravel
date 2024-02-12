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

class MenuCategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(
        public readonly RoleRepositoryInterface $roleRepo,
    )
    {}

    /**
     * Determine whether the user can view any models.
     * index
     */
    public function viewAny(User $user, Store $store): bool
    {
        // ログイン中のユーザーの所属グループと$storeの属するグループが同じものかどうかチェック
        if ($user->groups()->first()->id !== $store->group_id) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_INDEX_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_INDEX_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     * create
     * store
     */
    public function create(User $user, Store $store, int $storeId): bool
    {
        // ログイン中のユーザーの所属グループと$storeの属するグループが同じものかどうかチェック
        // 現在表示中のストアダッシュボードのストアIDと編集対象のストアIDが一致しているか
        if (
            $user->groups()->first()->id !== $store->group_id ||
            $store->id !== $storeId
        ) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_CREATE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_CREATE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     * edit
     * update
     */
    public function update(User $user, Store $store, int $storeId, int $paramStoreId): bool
    {
        // ログイン中のユーザーの所属グループと$storeの属するグループが同じものかどうかチェック
        // 現在表示中のストアダッシュボードのストアIDと編集対象のストアIDが一致しているか
        // 現在表示中のストアダッシュボードのストアIDとパラメータで渡されたストアIDが一致しているか
        if (
            $user->groups()->first()->id !== $store->group_id ||
            $store->id !== $storeId ||
            $store->id !== $paramStoreId
        ) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_UPDATE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_UPDATE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * softDelete
     */
    public function delete(User $user, Store $store, int $paramStoreId): bool
    {
        // ログイン中のユーザーの所属グループと$storeの属するグループが同じものかどうかチェック
        // 現在表示中のストアダッシュボードのストアIDと削除対象のストアIDが一致しているか
        if (
            $user->groups()->first()->id !== $store->group_id ||
            $store->id !== $paramStoreId
        ) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_ARCHIVE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_ARCHIVE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }
}
