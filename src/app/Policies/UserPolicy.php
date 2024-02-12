<?php

namespace App\Policies;

use App\Models\{
    User,
    RouteActionTarget,
};
use Illuminate\Auth\Access\Response;
use App\Repositories\{
    UserRepository\UserRepositoryInterface,
    GroupRepository\GroupRepositoryInterface,
    StoreRepository\StoreRepositoryInterface,
    RoleRepository\RoleRepositoryInterface,
};

class UserPolicy
{
    public function __construct(
        public readonly UserRepositoryInterface $userRepo,
        public readonly GroupRepositoryInterface $groupRepo,
        public readonly RoleRepositoryInterface $roleRepo,
        public readonly StoreRepositoryInterface $storeRepo,
    ) {}

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // 自グループのuserでなかった場合NG
        $authUserGroup = $this->groupRepo->getBelongingGroups($user);
        $targetUserGroup = $this->groupRepo->getBelongingGroups($model);

        if ($authUserGroup->id !== $targetUserGroup->id) {
            abort(403);
        }

        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // target.group
        // 自グループの所属ユーザのupdate権限があればok
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['USER_UPDATE_TARGET_GROUP']['id'])) {
            return true;
        }

        // target.store
        // authUserの所属店舗とtargetUserの所属店舗が同じ
        $authUserStoreIds = $this->storeRepo->getUserStores($user)->pluck('id');
        $targetUserStoreIds = $this->storeRepo->getUserStores($model)->pluck('id');
        $matchingStoreIds = $authUserStoreIds->intersect($targetUserStoreIds);

        if ($matchingStoreIds->isEmpty()) {
            abort(403);
        }

        foreach ($matchingStoreIds as $matchingStoreId) {
            // ユーザーの属するストアロール一覧を取得ここから!
            $storeRoles = $this->roleRepo->getUserStoreRoles($user, $matchingStoreId);
            foreach ($storeRoles as $storeRole) {
                if ($this->roleRepo->hasPermission($storeRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['USER_UPDATE_TARGET_STORE']['id'])) {
                    return true;
                }
            }
        }

        // target.self
        // なし

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
