<?php

namespace App\Repositories\ModifiedOrderRepository;

use App\Models\{
    ModifiedOrder,
    Order
};

interface ModifiedOrderRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 注文調整レコードを作成する
     * @param array $data
     * @return ModifiedOrder
     */
    public function createModifiedOrder(array $data): ModifiedOrder;

    /**
     * 注文調整レコードリストを作成する
     * @param array $data
     * @return bool
     */
    public function insertModifiedOrder(array $data): bool;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 注文ID(複数)に紐づく調整後注文レコードの有無を確認する
     * @param array $orderIds
     * @return bool
     */
    public function existsModifiedOrder(array $orderIds);

    /**
     * Orderから最新の調整後注文を取得する
     * @param Order $order
     * @return ?ModifiedOrder
     */
    public function getLatestModifiedOrder(Order $order): ?ModifiedOrder;

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
