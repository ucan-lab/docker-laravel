<?php

namespace App\Policies;

use App\Models\{
    Store,
    User,
    RouteActionTarget,
};
use Illuminate\Auth\Access\Response;
use App\Repositories\{
    RoleRepository\RoleRepositoryInterface,
};

class StorePolicy
{
    public function __construct(
        public readonly RoleRepositoryInterface $roleRepo,
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
    public function view(User $user, Store $store): bool
    {
        dd('view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // ユーザーの属するグループロールを取得
        $groupRole = $this->roleRepo->getUserGroupRole($user);

        // ルートアクションターゲットIDを保有しているロールがあるか確認
        if ($this->roleRepo->hasPermission($groupRole->role, RouteActionTarget::ROUTE_ACTION_TARGETS['STORE_CREATE_TARGET_GROUP']['id'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Store $store): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Store $store): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Store $store): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Store $store): bool
    {
        //
    }
}
