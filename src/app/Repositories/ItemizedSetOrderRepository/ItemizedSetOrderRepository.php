<?php

namespace App\Repositories\ItemizedSetOrderRepository;

use App\Models\{
    ItemizedSetOrder,
    Bill,
};

class ItemizedSetOrderRepository implements ItemizedSetOrderRepositoryInterface
{
    private $model;

    public function __construct(ItemizedSetOrder $itemizedSetOrder)
    {
        $this->model = $itemizedSetOrder;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 同一セット注文レコードの作成
     * @param array $date
     * @return ItemizedSetOrder
     */
    public function createItemizedSetOrder(array $date): ItemizedSetOrder
    {
        return $this->model->create($date);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 最新の同一セットオーダーIDを取得する
     * @param int $billId
     * @return ItemizedSetOrder
     */
    public function getLatestItemizedSetOrder(int $billId): ItemizedSetOrder
    {
        return $this->model->where('end_at', null)
            ->whereHas('itemizedOrder', function ($itemizedOrderQuery) use ($billId) {
                $itemizedOrderQuery->where('bill_id', $billId);
            })
            ->first();
    }

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * @param ItemizedSetOrder $itemizedSetOrder
     */
    public function updateItemizedSetOrder(ItemizedSetOrder $itemizedSetOrder)
    {
        $itemizedSetOrder->save();
    }

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/
}
