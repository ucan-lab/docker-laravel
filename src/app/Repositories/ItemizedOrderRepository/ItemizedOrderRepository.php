<?php

namespace App\Repositories\ItemizedOrderRepository;

use Illuminate\Support\Collection;
use App\Models\{
    ItemizedOrder,
    Bill,
};

class ItemizedOrderRepository implements ItemizedOrderRepositoryInterface
{
    private $model;

    public function __construct(ItemizedOrder $itemizedOrder)
    {
        $this->model = $itemizedOrder;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 一連の注文レコードの作成
     * @param int $billId
     * @return ItemizedOrder
     */
    public function createItemizedOrder(int $billId): ItemizedOrder
    {
        return $this->model->create([
            'bill_id' => $billId,
        ]);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 一連の注文を取得
     * @param int $id
     * @return ItemizedOrder
     */
    public function find(int $id): ItemizedOrder
    {
        return $this->model->find($id);
    }

    /**
     * 伝票に紐づく一連の注文を取得
     * @param Bill $bill
     * @return Collection
     */
    public function getBillItemizedOrders(Bill $bill): Collection
    {
        return $bill->itemizedOrders;
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
