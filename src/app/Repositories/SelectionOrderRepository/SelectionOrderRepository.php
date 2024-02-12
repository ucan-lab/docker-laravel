<?php

namespace App\Repositories\SelectionOrderRepository;

use Illuminate\Support\{
    Collection,
};
use App\Models\{
    SelectionOrder,
    ItemizedSetOrder,
};

class SelectionOrderRepository implements SelectionOrderRepositoryInterface
{
    private $model;

    public function __construct(SelectionOrder $selectionOrder)
    {
        $this->model = $selectionOrder;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 指名注文レコードの作成
     * @param array $data
     * @return SelectionOrder
     */
    public function createSelectionOrder(array $data): SelectionOrder
    {
        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * itemized_set_order_idに紐づく指名注文一覧を取得
     * @param int $itemizedSetOrderId
     * @return Collection
     */
    public function getSelectionOrdersBelongsToItemizedSetOrder(int $itemizedSetOrderId): Collection
    {
        return $this->model->where('itemized_set_order_id', $itemizedSetOrderId)->get();
    }

    /**
     * 特定の指名メニューに紐づく指名オーダー一覧を取得
     *
     * @param ItemizedSetOrder $itemizedSetOrder
     * @param int $selectionMenuId
     * @return Collection
     */
    public function getSelectionOrdersForItemizedSetOrderAndMenu(ItemizedSetOrder $itemizedSetOrder, int $selectionMenuId): Collection
    {
        return $this->model
            ->where('itemized_set_order_id', $itemizedSetOrder->id)
            ->whereHas('order', function ($query) use ($selectionMenuId) {
                $query->where('menu_id', $selectionMenuId);
            })
            ->get();
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
