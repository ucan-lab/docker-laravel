<?php

namespace App\Repositories\RoleRepository;

use Illuminate\Support\Collection;
use App\Repositories\RoleRepository\RoleRepositoryInterface;
use App\Models\{
    Role,
    Group,
    User,
    Store,
    DefaultGroupRole,
    DefaultStoreRole,
    GroupRole,
    StoreRole,
};


class RoleRepository implements RoleRepositoryInterface
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * ロールを作成する
     * @param string $roleName ロール名
     * @return Role
     */
    public function createRole(string $roleName): Role
    {
        return $this->model->create([
            'name' => $roleName
        ]);
    }

    /**
     * デフォルトグループロールに登録する
     * @param Role $role
     */
    public function createDefaultGroupRole(Role $role): void
    {
        $role->defaultGroupRole()->create([
            'role_id' => $role->id
        ]);
    }

    /**
     * デフォルトストアロールに登録する
     * @param Role $role
     */
    public function createDefaultStoreRole(Role $role): void
    {
        $role->defaultStoreRole()->create([
            'role_id' => $role->id
        ]);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * デフォルトグループロール(管理者)を取得
     * @return GroupRole
     */
    public function getDefaultAdminGroupRole(int $groupId): GroupRole
    {
        $roleName = DefaultGroupRole::DEFAULT_GROUP_ADMIN['name'];

        $role = $this->model->whereHas('defaultGroupRole', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        })
        ->first();

        return $role->groupRoles->where('role_id', $role->id)->where('group_id', $groupId)->first();
    }

    /**
     * ストアに属するストアロール一覧を取得
     * @param Store $store
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getStoreRolesByStore(Store $store, string $orderBy = 'id', string $sortBy = 'asc') :Collection
    {
        return StoreRole::where('store_id', $store->id)
            ->with('role')
            ->orderBy($orderBy, $sortBy)
            ->get();
    }

    /**
     * ユーザーのグループロール取得
     * @param User $user
     * @param int $groupId
     * @return GroupRole
     */
    public function getUserGroupRole(User $user): GroupRole
    {
        return $user->groupRoles()->with('role')->first();
    }

    /**
     * ユーザーの属するストアロールを取得
     * @param User $user
     * @param int $storeId
     * @return Collection
     */
    public function getUserStoreRoles(User $user, int $storeId): Collection
    {
        return $user->storeRoles()
        ->where('store_id', $storeId)
        ->with('role')
        ->get();
    }

    /**
     * デフォルトグループロール一覧を取得
     * @return Collection
     */
    public function getAllDefaultGroupRoles(): Collection
    {
        return DefaultGroupRole::get();
    }

    /**
     * グループに属するデフォルトグループロール
     * @param int $groupId
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getAllDefaultGroupRolesByGroupId(int $groupId, string $orderBy = 'id', string $sortBy = 'desc'): Collection
    {
        return GroupRole::where('group_id', $groupId)
            ->whereIn('role_id', DefaultGroupRole::with('role')->pluck('role_id'))
            ->with('role')
            ->orderBy($orderBy, $sortBy)
            ->get();
    }

    /**
     * ストアに属するデフォルトストアロールを取得
     * @param int $storeId
     * @return Collection
     */
    public function getAllDefaultStoreRolesByStoreId(int $storeId): Collection
    {
        return StoreRole::where('store_id', $storeId)
            ->whereIn('role_id', DefaultStoreRole::with('role')->pluck('role_id'))
            ->with('role')
            ->get();
    }

    /**
     * rolesTBLに登録されているデフォルトストアロール一覧を取得
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getAllDefaultStoreRoles(string $orderBy = 'id', string $sortBy = 'desc'): Collection
    {
        return DefaultStoreRole::with('role')
            ->orderBy($orderBy, $sortBy)
            ->get()
            ->pluck('role');
    }

    /**
     * ユーザーの属するロール一覧を取得
     * @param User $user
     * @return Collection
     */
    public function getRolesOfUser(User $user): Collection
    {
        return $user->roles;
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
    /**
     * ロールにルートアクションターゲットをアタッチする
     * @param Role $role
     * @param array $routeActionTargets
     */
    public function attachRouteActionTargetsToRole(Role $role, array $routeActionTargets): void
    {
        $role->routeActionTargets()->attach($routeActionTargets);
    }

    /**
     * ロール一覧をグループにアタッチする
     *  @param Group $group
     *  @param array $groupRoleIds
     */
    public function attachRolesToGroup(Group $group, array $groupRoleIds): void
    {
        $group->roles()->attach($groupRoleIds);
    }

    /**
     * ロール一覧をストアにアタッチする
     * @param array $roleIds
     * @param Store $store
     */
    public function attachRolesToStore(array $roleIds, Store $store): void
    {
        $store->roles()->attach($roleIds);
    }

    /**
     * グループロールをユーザーに同期する
     * @param User $user
     * @param array $groupRoleIds
     * @return void
     */
    public function syncGroupRoleUser(User $user, array $groupRoleIds): void
    {
        $user->groupRoles()->sync($groupRoleIds);
    }

    /**
     * ストアロールをユーザーに同期する
     * @param User $user
     * @param array $storeRoleIds
     * @return void
     */
    public function syncStoreRoleUser(User $user, array $storeRoleIds): void
    {
        $user->storeRoles()->sync($storeRoleIds);
    }

    /**
     * ユーザーに複数のグループロールを付与
     * @param User $user
     * @param array $groupRoleIds
     * @return void
     */
    public function attachGroupRolesToUser(User $user, array $groupRoleIds): void
    {
        $user->groupRoles()->attach($groupRoleIds);
    }

    /**
     * ユーザーに複数のストアロールを付与
     * @param User $user
     * @param array $storeRoleIds
     * @return void
     */
    public function attachStoreRolesToUser(User $user, array $storeRoleIds): void
    {
        $user->storeRoles()->attach($storeRoleIds);
    }

    /**
     * ロールの権限有無を確認する
     * @param Role $role ロール
     * @param int $route_action_target_id ルートアクションターゲットID
     * @param bool
     */
    public function hasPermission(Role $role, int $route_action_target_id): bool
    {
        return $role->routeActionTargets()
            ->where('route_action_target.id', $route_action_target_id)
            ->exists();
    }
}
