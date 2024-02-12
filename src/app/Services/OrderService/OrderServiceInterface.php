<?php

namespace App\Services\OrderService;

use Illuminate\Support\{
    Collection,
    Carbon
};
use App\Models\{
    StoreDetail
};

interface OrderServiceInterface
{
    /**
     * メニューのオーダー作成
     * @param StoreDetail $storeDetail
     * @param int $itemizedOrderId
     * @param int $menuId
     * @param int $quantity
     * @param int $incentiveTargetType
     * @param int $incentiveTargetId
     */
    public function createOrders(
        StoreDetail $storeDetail,
        int $itemizedOrderId,
        int $menuId,
        int $quantity,
        int $incentiveTargetType,
        int $incentiveTargetId
    );

    /**
     * 初回セットメニューのオーダー作成
     * @param int $itemizedOrderId
     * @param int $setMenuId
     * @param int $quantity
     * @param Carbon $startAt
     */
    public function createFirstSetOrders(
        int $itemizedOrderId,
        int $setMenuId,
        int $quantity,
        Carbon $startAt
    );

    /**
     * 延長セットメニューのオーダー作成
     * @param int $itemizedOrderId
     * @param int $setMenuId
     * @param int $quantity
     */
    public function createExtensionSetOrders(
        int $itemizedOrderId,
        int $setMenuId,
        int $quantity
    );

    /**
     * 注文情報を更新する
     * @param StoreDetail $storeDetail
     * @param int $itemizedOrderId
     * @param array $orderIds
     * @param int $quantity
     * @param int $adjust_amount
     * @param ?int $newUserIncentiveAmount
     * @param int $sysMenuCategoryId
     */
    public function updateOrder(
        StoreDetail $storeDetail,
        int $itemizedOrderId,
        array $orderIds,
        int $quantity,
        int $adjustAmount,
        ?int $newUserIncentiveAmount,
        int $sysMenuCategoryId
    );
}
