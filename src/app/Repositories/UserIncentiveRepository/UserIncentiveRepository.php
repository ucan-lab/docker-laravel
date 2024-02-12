<?php

namespace App\Repositories\UserIncentiveRepository;

use Illuminate\Support\{
    Collection
};
use App\Models\{
    UserIncentive,
    Order
};

class UserIncentiveRepository implements UserIncentiveRepositoryInterface
{
    private $model;

    public function __construct(UserIncentive $userIncentive)
    {
        $this->model = $userIncentive;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * ユーザーインセンティブレコードの作成
     * @param array $data
     * @return UserIncentive
     */
    public function createUserIncentive(array $data): UserIncentive
    {
        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 注文に紐づくユーザーインセンティブ取得
     * @param Order $order
     * @return UserIncentive
     */
    public function getOrderUserIncentive(Order $order): UserIncentive
    {
        return $order->userIncentive;
    }

    /**
     * 注文ID(複数)に紐づくユーザーインセンティブ取得
     * @param array $orderIds
     * @return Collection
     */
    public function getOrdersUserIncentives(array $orderIds): Collection
    {
        return $this->model->whereIn('order_id', $orderIds)->get();
    }

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * ソフトデリートする
     * @param UserIncentive $userIncentive
     * @return bool
     */
    public function softDeletes(UserIncentive $userIncentive): bool
    {
        return $userIncentive->delete();
    }

    /***********************************************************
     * その他
     ***********************************************************/
}
