<?php

namespace App\Policies;

use App\Models\{
    User,
    RouteActionTarget,
    Store,
    Menu
};
use App\Repositories\{
    RoleRepository\RoleRepositoryInterface,
    MenuCategoryRepository\MenuCategoryRepositoryInterface,
};

class MenuPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(
        public readonly RoleRepositoryInterface $roleRepo,
        public readonly MenuCategoryRepositoryInterface $menuCategoryRepo,
    )
    {}

    /**
     * indexメソッド
     * @param User $user
     * @param Store $store
     * @return bool
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
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_INDEX_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_INDEX_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * createメソッド
     * @param User $user
     * @param Store $store
     * @return bool
     */
    public function create(User $user, Store $store): bool
    {
        // ログイン中のユーザーの所属グループと$storeの属するグループが同じものかどうかチェック
        if ($user->groups()->first()->id !== $store->group_id) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_CREATE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_CREATE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * storeメソッド
     * @param User $user
     * @param Store $store
     * @param int $menuCategoryId
     * @return bool
     */
    public function store(User $user, Store $store, int $menuCategoryId): bool
    {
        // ログイン中のユーザーの所属グループと$storeの属するグループが同じものかどうかチェック
        if ($user->groups()->first()->id !== $store->group_id) {
            return false;
        }

        // 新規作成するメニューのメニューカテゴリIDが編集対象のストアIDに属しているか
        if (!$this->isMenuCategoryBelongsToStore($store, $menuCategoryId)) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_STORE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_STORE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * updateメソッド
     * @param User $user
     * @param Store $store
     * @param Menu $menu
     * @param int $paramMenuCategoryId
     * @return bool
     */
    public function update(User $user, Store $store, Menu $menu, int $paramMenuCategoryId): bool
    {
        // ログイン中のユーザーの所属グループと$storeの属するグループが同じものかどうかチェック
        if ($user->groups()->first()->id !== $store->group_id) {
            return false;
        }

        // 更新するメニューのメニューカテゴリIDが現在表示中のストアのIDに属しているか
        if (!$this->isMenuCategoryBelongsToStore($store, $menu->menu_category_id) ||
            !$this->isMenuCategoryBelongsToStore($store, $paramMenuCategoryId)
        ) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_UPDATE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_UPDATE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * deleteメソッド
     * @param User $user
     * @param Store $store
     * @param int $menuCategoryId
     * @return bool
     */
    public function delete(User $user, Store $store, int $menuCategoryId): bool
    {
        // ログイン中のユーザーの所属グループと$storeの属するグループが同じものかどうかチェック
        if ($user->groups()->first()->id !== $store->group_id) {
            return false;
        }

        // 削除するメニューのメニューカテゴリIDが現在表示中のストアのIDに属しているか
        if (!$this->isMenuCategoryBelongsToStore($store, $menuCategoryId)) {
            return false;
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_ARCHIVE_TARGET_GROUP']['id'])) {
            return true;
        }

        // ユーザーの属するストアロール一覧を取得
        $storeRoles = $this->roleRepo->getUserStoreRoles($user, $store->id);

        foreach ($storeRoles as $storeRole) {
            if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_ARCHIVE_TARGET_STORE']['id'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * 指定したメニューカテゴリが店舗に紐づいているか
     * @param Store $store
     * @param int $menuCategoryId
     */
    private function isMenuCategoryBelongsToStore(Store $store, int $menuCategoryId): bool
    {
        // 更新するメニューのメニューカテゴリIDが現在表示中のストアのIDに属しているか
        $menuCategory = $this->menuCategoryRepo->findOrFail($menuCategoryId);

        return $menuCategory->store_id === $store->id;
    }
}
