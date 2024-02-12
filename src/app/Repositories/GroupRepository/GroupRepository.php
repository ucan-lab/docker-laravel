<?php

namespace App\Repositories\GroupRepository;

use App\Repositories\GroupRepository\GroupRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\{
    Group,
    User
};


class GroupRepository implements GroupRepositoryInterface
{
    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * グループを作成する
     *
     * @param array $data グループ作成に必要なデータ
     * @return Group 作成されたグループ
     */
    public function createGroup(array $data): Group
    {
        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * ユーザーの所属グループを取得
     * @param User $user
     * @return Group
     */
    public function getBelongingGroups(User $user): Group
    {
        return $user->groups()->first();
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
}
