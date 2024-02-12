<?php

namespace App\Services\RegisteredUserService;
use App\Models\{
    User,
};

interface RegisteredUserServiceInterface
{
    /**
     * 引数.userを契約者として登録する
     * @param User $user
     * @param string $groupName
     */
    public function registerContractUser(User $user, string $groupName);
}
