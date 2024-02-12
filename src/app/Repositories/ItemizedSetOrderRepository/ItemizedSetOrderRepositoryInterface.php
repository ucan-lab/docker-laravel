<?php

namespace App\Repositories\ItemizedSetOrderRepository;

use Illuminate\Support\Collection;
use App\Models\{
    ItemizedSetOrder,
    Bill,
};

interface ItemizedSetOrderRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 同一セット注文レコードの作成
     * @param array $date
     * @return ItemizedSetOrder
     */
    public function createItemizedSetOrder(array $date): ItemizedSetOrder;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 最新の同一セットオーダーIDを取得する
     * @param int $billId
     * @return ItemizedSetOrder
     */
    public function getLatestItemizedSetOrder(int $billId): ItemizedSetOrder;

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * @param ItemizedSetOrder $itemizedSetOrder
     */
    public function updateItemizedSetOrder(ItemizedSetOrder $itemizedSetOrder);

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/
}
