<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{
    Role,
    DefaultGroupRole,
    DefaultStoreRole
};
use App\Repositories\{
    RoleRepository\RoleRepositoryInterface,
};

class RolesTableSeeder extends Seeder
{
    public function __construct(
        public readonly RoleRepositoryInterface $roleRepo,
    ) {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // デフォルトグループロール
        foreach (DefaultGroupRole::DEFAULT_GROUP_ROLES as $defaultRole) {
            // ロールを作成する
            $role = $this->roleRepo->createRole($defaultRole['name']);

            // ロールにルートアクションターゲットを付与する
            $this->roleRepo->attachRouteActionTargetsToRole($role, $defaultRole['routeActionTargets']);

            // デフォルトグループロールに登録
            $this->roleRepo->createDefaultGroupRole($role);
        }

        // デフォルトストアロール
        foreach (DefaultStoreRole::DEFAULT_STORE_ROLES as $defaultRole) {
            // ロールを作成する
            $role = $this->roleRepo->createRole($defaultRole['name']);

            // ロールにルートアクションターゲットを付与する
            $this->roleRepo->attachRouteActionTargetsToRole($role, $defaultRole['routeActionTargets']);

            // デフォルトグループロールに登録
            $this->roleRepo->createDefaultStoreRole($role);
        }

    }
}
