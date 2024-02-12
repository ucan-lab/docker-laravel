<?php

namespace App\Repositories\OrderRepository;

use Illuminate\Support\Collection;
use App\Models\{
    Order,
    ItemizedOrder,
};

class OrderRepository implements OrderRepositoryInterface
{
    private $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 注文レコードの作成
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data): Order
    {
        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 一連の注文に紐づくオーダーを取得
     * @param ItemizedOrder $itemizedOrder
     * @return Collection
     */
    public function getItemizedOrderOrders(ItemizedOrder $itemizedOrder): Collection
    {
        $orders = $itemizedOrder->orders()->with('menu')->get();
        foreach ($orders as $order_i => $order) {
            $orders[$order_i]['set_menu'] = $order->menu->setMenu;
            $orders[$order_i]['menu']['menu_category'] = $orders[$order_i]['menu']->menuCategory;
            $orders[$order_i]['user_incentive'] = $order->userIncentive;
            $orders[$order_i]['modified_order'] = $order->modifiedOrders()->latest()->first();
            if (!is_null($orders[$order_i]['user_incentive'])) {
                $orders[$order_i]['user_incentive']['user'] = $orders[$order_i]['user_incentive']->user;
            }
        }

        return $orders;
    }

    /**
     * ID指定で注文を取得
     * @param int $id
     * @return Order
     */
    public function find(int $id): Order
    {
        return $this->model->find($id);
    }

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * ID指定で論理削除
     * @param int $orderId
     */
    public function softDelete(int $orderId)
    {
        return $this->model->find($orderId)->delete();
    }

    /***********************************************************
     * その他
     ***********************************************************/
}
