<?php

namespace App\Policies;

use App\Models\{
    PaymentMethod,
    User,
    RouteActionTarget,
    Store,
};
use App\Repositories\{
    RoleRepository\RoleRepositoryInterface,
};

class PaymentMethodPolicy
{
    public function __construct(
        public readonly RoleRepositoryInterface $roleRepo,
    ) {}

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Store $store): bool
    {
        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_INDEX_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_INDEX_TARGET_STORE']['id'])) {
                return true;

            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Store $store, int $storeId): bool
    {
        // urlParamから注入されたストアIDとformのストアIDが一致しているか
        if ($store->id !== $storeId) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // BUG::自グループに所属している店舗かのチェックが必要

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_CREATE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_CREATE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Store $store, PaymentMethod $paymentMethod, int $paramStoreId): bool
    {
        // urlParamから注入されたストアIDとformのストアIDが一致しているか
        if (
            $store->id !== $paymentMethod->store_id ||
            $store->id !== $paramStoreId
            ) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_UPDATE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_UPDATE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Store $store, PaymentMethod $paymentMethod): bool
    {
         // urlParamから注入されたストアIDとformのストアIDが一致しているか
         if ($store->id !== $paymentMethod->store_id) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_ARCHIVE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_ARCHIVE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }
}
