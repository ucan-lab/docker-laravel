<?php

namespace App\Repositories\ItemizedOrderRepository;

use Illuminate\Support\Collection;
use App\Models\{
    ItemizedOrder,
    Bill,
};

interface ItemizedOrderRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 一連の注文レコードの作成
     * @param int $billId
     * @return ItemizedOrder
     */
    public function createItemizedOrder(int $billId): ItemizedOrder;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 一連の注文を取得
     * @param int $id
     * @return ItemizedOrder
     */
    public function find(int $id): ItemizedOrder;

    /**
     * 伝票に紐づく一連の注文を取得
     * @param Bill $bill
     * @return Collection
     */
    public function getBillItemizedOrders(Bill $bill): Collection;

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
