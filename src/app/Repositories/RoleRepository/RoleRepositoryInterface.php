<?php

namespace App\Repositories\RoleRepository;

use App\Models\{
    Role,
    Group,
    GroupRole,
    User,
    Store,
};
use Illuminate\Support\Collection;

interface RoleRepositoryInterface
{

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * ロールを作成する
     * @param string $roleName ロール名
     * @return Role
     */
    public function createRole(string $roleName): Role;

    /**
     * デフォルトグループロールに登録する
     * @param Role $role
     */
    public function createDefaultGroupRole(Role $role): void;

    /**
     * デフォルトストアロールに登録する
     * @param Role $role
     */
    public function createDefaultStoreRole(Role $role): void;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * デフォルトグループロール(管理者)を取得
     * @return GroupRole
     */
    public function getDefaultAdminGroupRole(int $groupId): GroupRole;

    /**
     * ストアに属するストアロール一覧を取得
     * @param Store $store
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getStoreRolesByStore(Store $store, string $orderBy = 'id', string $sortBy = 'asc') :Collection;

    /**
     * ユーザーのグループロール取得
     * @param User $user
     * @return GroupRole
     */
    public function getUserGroupRole(User $user): GroupRole;

    /**
     * ユーザーの属するストアロールを取得
     * @param User $user
     * @param int $storeId
     * @return Collection
     */
    public function getUserStoreRoles(User $user, int $storeId): Collection;

    /**
     * デフォルトグループロール一覧を取得
     * @return Collection
     */
    public function getAllDefaultGroupRoles(): Collection;

    /**
     * グループに属するデフォルトグループロール
     * @param int $groupId
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getAllDefaultGroupRolesByGroupId(int $groupId, string $orderBy = 'id', string $sortBy = 'desc'): Collection;

    /**
     * ストアに属するデフォルトストアロールを取得
     * @param int $storeId
     * @return Collection
     */
    public function getAllDefaultStoreRolesByStoreId(int $storeId): Collection;

    /**
     * rolesTBLに登録されているデフォルトストアロール一覧を取得
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getAllDefaultStoreRoles(string $orderBy = 'id', string $sortBy = 'desc'): Collection;

    /**
     * ユーザーの属するロール一覧を取得
     * @param User $user
     * @param Collection
     */
    public function getRolesOfUser(User $user): Collection;

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/
    /**
     * ロールにルートアクションターゲットをアタッチする
     * @param Role $role
     * @param array $routeActionTargets
     */
    public function attachRouteActionTargetsToRole(Role $role, array $routeActionTargets): void;

    /**
     * ロール一覧をグループにアタッチする
     *  @param Group $group
     *  @param array $groupRoleIds
     */
    public function attachRolesToGroup(Group $group, array $groupRoleIds): void;

    /**
     * ロール一覧をストアにアタッチする
     * @param array $roleIds
     * @param Store $store
     */
    public function attachRolesToStore(array $roleIds, Store $store): void;

    /**
     * グループロールをユーザーに同期する
     * @param User $user
     * @param array $groupRoleIds
     * @return void
     */
    public function syncGroupRoleUser(User $user, array $groupRoleIds): void;

    /**
     * ストアロールをユーザーに同期する
     * @param User $user
     * @param array $storeRoleIds
     * @return void
     */
    public function syncStoreRoleUser(User $user, array $storeRoleIds): void;

    /**
     * ユーザーに複数のグループロールを付与
     * @param User $user
     * @param array $groupRoleIds
     * @return void
     */
    public function attachGroupRolesToUser(User $user, array $groupRoleIds): void;

    /**
     * ユーザーに複数のストアロールを付与
     * @param User $user
     * @param array $storeRoleIds
     * @return void
     */
    public function attachStoreRolesToUser(User $user, array $storeRoleIds): void;

    /**
     * ロールの権限有無を確認する
     * @param Role $role ロール
     * @param int $route_action_target_id ルートアクションターゲットID
     * @param bool
     */
    public function hasPermission(Role $role, int $route_action_target_id): bool;
}
