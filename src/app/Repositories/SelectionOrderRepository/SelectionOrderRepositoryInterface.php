<?php

namespace App\Repositories\SelectionOrderRepository;

use Illuminate\Support\{
    Collection,
};
use App\Models\{
    SelectionOrder,
    ItemizedSetOrder,
    Menu,
};

interface SelectionOrderRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 指名注文レコードの作成
     * @param array $data
     * @return SelectionOrder
     */
    public function createSelectionOrder(array $data): SelectionOrder;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * itemized_set_order_idに紐づく指名注文一覧を取得
     * @param int $itemizedSetOrderId
     * @return Collection
     */
    public function getSelectionOrdersBelongsToItemizedSetOrder(int $itemizedSetOrderId): Collection;

    /**
     * 特定の指名メニューに紐づく指名オーダー一覧を取得
     *
     * @param ItemizedSetOrder $itemizedSetOrder
     * @param int $selectionMenuId
     * @return Collection
     */
    public function getSelectionOrdersForItemizedSetOrderAndMenu(ItemizedSetOrder $itemizedSetOrder, int $selectionMenuId): Collection;

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
