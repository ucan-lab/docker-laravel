<?php

namespace App\Repositories\OrderRepository;

use Illuminate\Support\Collection;
use App\Models\{
    Order,
    ItemizedOrder,
};

interface OrderRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 注文レコードの作成
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data): Order;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 一連の注文に紐づくオーダーを取得
     * @param ItemizedOrder $itemizedOrder
     * @return Collection
     */
    public function getItemizedOrderOrders(ItemizedOrder $itemizedOrder): Collection;

    /**
     * ID指定で注文を取得
     * @param int $id
     * @return Order
     */
    public function find(int $id): Order;

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
    public function softDelete(int $orderId);

    /***********************************************************
     * その他
     ***********************************************************/
}
