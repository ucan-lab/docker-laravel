<?php

namespace App\Repositories\UserRepository;

use Illuminate\Database\Eloquent\Collection;
use App\Models\{
    Group,
    User,
    ContractUser,
    GeneralUser,
    Store,
    StoreRole,
    BusinessDate,
};
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * ユーザーを作成する
     *
     * @param array $data ユーザー作成に必要なデータ
     * @return User 作成されたユーザー
     */
    public function createUser(array $data): User
    {
        return $this->model->create($data);
    }

    /**
     * 契約ユーザーを作成する
     * @param User $user
     * @return ContractUser
     */
    public function createContractUser(User $user)
    {
        return $user->contractUser()->create([
            'user_id' => $user->id
        ]);
    }

    /**
     * 一般ユーザーを作成する
     * @param array $data ユーザー作成に必要なデータ
     * @param array $generalUserdata
     * @return User
     */
    public function createGeneralUser(array $data, array $generalUserdata): User
    {
        $user = $this->createUser($data);

        $loginPermission = GeneralUser::getById($generalUserdata['can_login']);

        $user->generalUser()->create([
            'user_id' => $user->id,
            'can_login' => $loginPermission['can_login']
        ]);

        return $user;
    }

    /***********************************************************
     * Read系
     ***********************************************************/

    /**
     * user_idを元にユーザーを取得する
     * @param int $user_id
     * @return User
     */
    public function find(int $user_id): User
    {
        return $this->model->find($user_id);
    }

    /**
     * グループに属するユーザー一覧を取得
     * @param Group $group
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function listGroupUsers(Group $group, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $group->users()
            ->orderBy($orderBy, $sortBy)
            ->get($columns);
    }

    /**
     * 一般ユーザーデータを取得する
     * @param User $user
     * @return ?GeneralUser
     */
    public function getGeneralUserData(User $user): ?GeneralUser
    {
        return $user->generalUser;
    }

    /**
     * 店舗に紐づくユーザー一覧を取得
     * @param Store $store
     * @return Collection
     */
    public function getStoreUsers(Store $store, $columns = array('*'), string $orderBy = 'display_name', string $sortBy = 'desc'): Collection
    {
        return $store->users()
            ->orderBy($orderBy, $sortBy)
            ->get($columns);
    }

    /**
     * ストアロールに属する出勤ユーザー一覧を取得
     * @param StoreRole $storeRole
     * @param BusinessDate $businessDate
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getAttendanceUsersByStoreRole(StoreRole $storeRole, BusinessDate $businessDate, $columns = array('*'), string $orderBy = 'display_name', string $sortBy = 'asc'): Collection
    {
        return $storeRole->users()
            ->whereHas('attendances', function ($query) use ($businessDate) {
                $query->where('business_date_id', $businessDate->id)
                    ->whereNotNull('working_start_at');
            })
            ->orderBy($orderBy, $sortBy)
            ->get($columns);
    }

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * ユーザーを更新する
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updateUser(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * 一般ユーザーを更新する
     * @param User $user
     * @param array $userData
     * @param array $generalUserData
     * @return bool
     */
    public function updateGeneralUser(User $user, array $userData, array $generalUserData): bool
    {
        $this->updateUser($user, $userData);

        return $user->generalUser->update([
            'can_login' => GeneralUser::getById($generalUserData['can_login'])['can_login']
        ]);
    }

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * ユーザーをソフトデリートする
     * @param User $user
     * @return void
     */
    public function softDeleteUser(User $user): void
    {
        $user->delete();
    }

    /***********************************************************
     * その他
     ***********************************************************/
    /**
     * グループにユーザーを所属させる
     * @param User $user
     * @param Group $group
     * @return void
     */
    public function attachToGroup(User $user, Group $group): void
    {
        $user->groups()->attach($group->id);
    }

    /**
     * ストアにユーザーを所属させる
     * @param User $user
     * @param array $storeIds
     * @return void
     */
    public function attachToStores(User $user, array $storeIds): void
    {
        $user->stores()->attach($storeIds);
    }
}
