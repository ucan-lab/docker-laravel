<?php

namespace App\Services\RoleService;

use Illuminate\Support\Collection;
use App\Models\{
    Group
};

interface RoleServiceInterface
{
    /**
     * グループに属するストア一覧のストアロール一覧を取得
     * @param Group $group
     * @return Collection
     */
    public function getStoresRolesByGroup(Group $group): Collection;
}
