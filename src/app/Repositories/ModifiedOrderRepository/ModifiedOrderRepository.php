<?php

namespace App\Repositories\ModifiedOrderRepository;

use App\Models\{
    ModifiedOrder,
    Order
};

class ModifiedOrderRepository implements ModifiedOrderRepositoryInterface
{
    private $model;

    public function __construct(ModifiedOrder $modifiedOrder)
    {
        $this->model = $modifiedOrder;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 注文調整レコードを作成する
     * @param array $data
     * @return ModifiedOrder
     */
    public function createModifiedOrder(array $data): ModifiedOrder
    {
        return $this->model->create($data);
    }

    /**
     * 注文調整レコードリストを作成する
     * @param array $data
     * @return bool
     */
    public function insertModifiedOrder(array $data): bool
    {
        return $this->model->insert($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 注文ID(複数)に紐づく注文調整レコードの有無を確認する
     * @param array $orderIds
     * @return bool
     */
    public function existsModifiedOrder(array $orderIds)
    {
        return $this->model->whereIn('order_id', $orderIds)->exists();
    }

    /**
     * Orderから最新の調整後注文を取得する
     * @param Order $order
     * @return ?ModifiedOrder
     */
    public function getLatestModifiedOrder(Order $order): ?ModifiedOrder
    {
        return $order->modifiedOrders()->latest()->first();
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
