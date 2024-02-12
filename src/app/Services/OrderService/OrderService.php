<?php

namespace App\Services\OrderService;

use Illuminate\Support\{
    Carbon,
    Collection
};
use App\Services\OrderService\OrderServiceInterface;
use App\Models\{
    UserIncentive,
    StoreDetail,
    RoundingMethod,
    Digit,
    Menu,
    SysMenuCategory,
    Order,
};
use App\Repositories\{
    OrderRepository\OrderRepositoryInterface,
    TableRepository\TableRepositoryInterface,
    ItemizedOrderRepository\ItemizedOrderRepositoryInterface,
    NumberOfCustomerRepository\NumberOfCustomerRepositoryInterface,
    UserIncentiveRepository\UserIncentiveRepositoryInterface,
    MenuRepository\MenuRepositoryInterface,
    MenuCategoryRepository\MenuCategoryRepositoryInterface,
    BillRepository\BillRepositoryInterface,
    SelectionOrderRepository\SelectionOrderRepositoryInterface,
    ItemizedSetOrderRepository\ItemizedSetOrderRepositoryInterface,
    ModifiedOrderRepository\ModifiedOrderRepositoryInterface,
};

class OrderService implements OrderServiceInterface
{
    public function __construct(
        public readonly TableRepositoryInterface $tableRepo,
        public readonly ItemizedOrderRepositoryInterface $itemizedOrderRepo,
        public readonly OrderRepositoryInterface $orderRepo,
        public readonly NumberOfCustomerRepositoryInterface $numberOfCustomerRepo,
        public readonly UserIncentiveRepositoryInterface $userIncentiveRepo,
        public readonly MenuRepositoryInterface $menuRepo,
        public readonly MenuCategoryRepositoryInterface $menuCategoryRepo,
        public readonly BillRepositoryInterface $billRepo,
        public readonly SelectionOrderRepositoryInterface $selectionOrderRepo,
        public readonly ItemizedSetOrderRepositoryInterface $itemizedSetOrderRepo,
        public readonly ModifiedOrderRepositoryInterface $modifiedOrderRepo,
    ) {
    }

    /**
     * メニュー(指名、飲食)のオーダー作成
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
    ): Collection
    {
        // メニューカテゴリ取得
        $menu = $this->menuRepo->find($menuId);
        $menuCategory = $this->menuCategoryRepo->getMenuMenuCategory($menu);

        $orderData = [
            'itemized_order_id' => $itemizedOrderId,
            'menu_id' => $menu->id,
        ];

        // 飲食メニュー
        if($menuCategory->sys_menu_category_id === SysMenuCategory::CATEGORIES['DRINK_FOOD']['id'])
        {
            return $this->createFoodDrinkOrders(
                $storeDetail,
                $orderData,
                $itemizedOrderId,
                $menu,
                $quantity,
                $incentiveTargetType,
                $incentiveTargetId,
            );
        }


        // 指名メニュー
        if($menuCategory->sys_menu_category_id === SysMenuCategory::CATEGORIES['SELECTION']['id'])
        {
            return $this->createSelectionOrders(
                $itemizedOrderId,
                $storeDetail,
                $orderData,
                $menu,
                $quantity,
                $incentiveTargetId
            );
        }

        return collect();
    }

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
    ) {
        // 同一セット注文を作成
        $itemizedSetOrder = $this->itemizedSetOrderRepo->createItemizedSetOrder([
            'itemized_order_id' => $itemizedOrderId,
            'start_at' => $startAt
        ]);

        // 各セット注文を作成
        for ($quantity_i=0; $quantity_i < $quantity; $quantity_i++) {
            $this->orderRepo->createOrder([
                'itemized_order_id' => $itemizedOrderId,
                'menu_id' => $setMenuId,
            ]);
        }
    }

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
    ) {
        // billを取得
        $bill = $this->billRepo->getBillByItemizedOrderId($itemizedOrderId);

        // 現在のItemizedSetOrder取得
        $latestItemizedSetOrder = $this->itemizedSetOrderRepo->getLatestItemizedSetOrder($bill->id);

        // 現在のセットに紐づく指名注文を取得
        $latestSelectionOrders = $this->selectionOrderRepo->getSelectionOrdersBelongsToItemizedSetOrder(
            $latestItemizedSetOrder->id
        );
        $startAt = $this->getExtensionSetStartAt();

        // 直前のセット注文のEndAtを現在時刻で更新
        $latestItemizedSetOrder->end_at = $startAt;
        $this->itemizedSetOrderRepo->updateItemizedSetOrder($latestItemizedSetOrder);

        // 次のItemizedSetOrderを作成
        $nextItemizedSetOrder = $this->itemizedSetOrderRepo->createItemizedSetOrder([
            'itemized_order_id' => $itemizedOrderId,
            'start_at' => $startAt
        ]);

        // 現在のセット注文（延長）を登録
        for ($quantity_i=0; $quantity_i < $quantity; $quantity_i++) {
            $this->orderRepo->createOrder([
                'itemized_order_id' => $itemizedOrderId,
                'menu_id' => $setMenuId,
            ]);
        }

        // 現在のセット注文に直前のセットに紐づく指名注文を再注文する
        foreach ($latestSelectionOrders as $latestSelectionOrder) {
            $order = $this->orderRepo->find($latestSelectionOrder->order_id);

            $userIncentive = $this->userIncentiveRepo->getOrderUserIncentive($order);

            // 新規で注文を作成
            $createdOrder = $this->orderRepo->createOrder([
                'itemized_order_id' => $itemizedOrderId,
                'menu_id' => $order->menu_id,
            ]);

            // 新規でユーザーインセンティブを作成
            $this->userIncentiveRepo->createUserIncentive([
                'user_id' => $userIncentive->user_id,
                'order_id' => $createdOrder->id,
                'amount' => $userIncentive->amount
            ]);

            // 新規で指名特化テーブル登録
            $this->selectionOrderRepo->createSelectionOrder([
                'itemized_set_order_id' => $nextItemizedSetOrder->id,
                'order_id' => $createdOrder->id,
                'user_id' => $latestSelectionOrder->user_id,
            ]);
        }
    }

    /**
     * 延長セットの開始日時を取得する
     */
    private function getExtensionSetStartAt(): Carbon
    {
        // TODO: 現在のセットの終了時刻から開始のパターンと、現在時刻から開始のパターン
        return Carbon::now();
    }

    /**
     * 飲食メニューのオーダー作成
     * @param StoreDetail $storeDetail
     * @param array $orderData
     * @param int $itemizedOrderId
     * @param Menu $menu
     * @param int $quantity
     * @param int $incentiveTargetType
     * @param int $incentiveTargetId
     */
    private function createFoodDrinkOrders(
        StoreDetail $storeDetail,
        array $orderData,
        int $itemizedOrderId,
        Menu $menu,
        int $quantity,
        int $incentiveTargetType,
        int $incentiveTargetId
    ): Collection
    {
        // $incentiveTargetUserIds取得
        $incentiveTargetUserIds = $this->getIncentiveTargetUserIds($incentiveTargetType, $incentiveTargetId, $itemizedOrderId, $menu);
        $orders = collect();
        for ($quantity_i=0; $quantity_i < $quantity; $quantity_i++) {
            $orders->push(
                $this->createFoodDrinkOrder(
                $storeDetail,
                $orderData,
                $menu,
                $incentiveTargetUserIds
                )
            );
        }
        return $orders;
    }

    /**
     * 飲食メニュー登録
     * @param StoreDetail $storeDetail
     * @param array $orderData
     * @param Menu $menu
     * @param array $incentiveTargetUserIds
     */
    private function createFoodDrinkOrder(
        StoreDetail $storeDetail,
        array $orderData,
        Menu $menu,
        $incentiveTargetUserIds
    ): Order
    {
        $order = $this->orderRepo->createOrder($orderData);

        // バック先の指定がない場合はreturn
        if (is_null($incentiveTargetUserIds)) return $order;

        // バック金額の計算
        $amount = $this->getIncentiveAmount($storeDetail, $menu, count($incentiveTargetUserIds));

        foreach ($incentiveTargetUserIds as $incentiveTargetUserId) {
            // UserIncentiveの作成
            $userIncentiveData = [
                'user_id' => $incentiveTargetUserId,
                'order_id' => $order->id,
                'amount' => $amount
            ];

            $userIncentive = $this->userIncentiveRepo->createUserIncentive($userIncentiveData);
        }

        return $order;
    }

    /**
     * 指名メニュー一覧のオーダー作成
     * @param int $itemizedOrderId
     * @param StoreDetail $storeDetail
     * @param array $orderData
     * @param Menu $menu
     * @param int $quantity
     * @param int $incentiveTargetId
     */
    private function createSelectionOrders(
        int $itemizedOrderId,
        StoreDetail $storeDetail,
        array $orderData,
        Menu $menu,
        int $quantity,
        int $incentiveTargetId
    ): Collection
    {
        // 現在のセットを取得
        // billを取得
        $bill = $this->billRepo->getBillByItemizedOrderId($itemizedOrderId);

        // 現在のセット取得
        $latestItemizedSetOrder = $this->itemizedSetOrderRepo->getLatestItemizedSetOrder($bill->id);

        $orders = collect();

        for ($quantity_i=0; $quantity_i < $quantity; $quantity_i++) {
            // orderの作成
            $orders->push(
                $this->createSelectionOrder(
                    $storeDetail,
                    $latestItemizedSetOrder->id,
                    $orderData,
                    $menu,
                    $incentiveTargetId
                )
            );
        }

        return $orders;
    }

    /**
     * 指名メニューのオーダー作成
     * @param StoreDetail $storeDetail
     * @param array $orderData
     * @param Menu $menu
     * @param int $incentiveTargetUserId
     * @return Order
     */
    private function createSelectionOrder(
        StoreDetail $storeDetail,
        int $itemizedSetOrderId,
        array $orderData,
        Menu $menu,
        int $incentiveTargetUserId
    ): Order
    {
        // ここから共通化できそう(飲食と一緒)
        $order = $this->orderRepo->createOrder($orderData);

        // バック金額の計算
        $amount = $this->getIncentiveAmount($storeDetail, $menu, 1);

        // UserIncentiveの作成
        $userIncentiveData = [
            'user_id' => $incentiveTargetUserId,
            'order_id' => $order->id,
            'amount' => $amount
        ];

        $userIncentive = $this->userIncentiveRepo->createUserIncentive($userIncentiveData);
        // ここまで

        // 指名特化テーブル登録
        $selectionOrder = $this->selectionOrderRepo->createSelectionOrder([
            'itemized_set_order_id' => $itemizedSetOrderId,
            'order_id' => $order->id,
            'user_id' => $incentiveTargetUserId,
        ]);

        return $order;
    }

    /**
     * バック先対象ユーザーID一覧を取得
     * @param int $incentiveTargetType
     * @param int $incentiveTargetId
     * @param int $itemizedOrderId,
    *  @param Menu $menu,
     * @return ?array
     */
    private function getIncentiveTargetUserIds(
        int $incentiveTargetType,
        int $incentiveTargetId,
        int $itemizedOrderId,
        Menu $menu,
        ): ?array
    {
        // バック先なしの場合
        if ($incentiveTargetType == UserIncentive::INCENTIVE_TARGET['NONE']['type']) {
            return null;
        }

        // ユーザー選択の場合
        if ($incentiveTargetType == UserIncentive::INCENTIVE_TARGET['USER']['type']) {
            return [$incentiveTargetId];
        }

        // 等分シリーズ
        if ($incentiveTargetType == UserIncentive::INCENTIVE_TARGET['SELECTION']['type']) {

            // 現在のセットに紐づく指名種別のユーザー一覧を取得
            $latestItemizedOrder = $this->itemizedOrderRepo->find($itemizedOrderId);

            $latestItemizedSetOrder = $this->itemizedSetOrderRepo->getLatestItemizedSetOrder(
                $latestItemizedOrder->bill_id
            );

            $selectionOrders = $this->selectionOrderRepo->getSelectionOrdersForItemizedSetOrderAndMenu(
                $latestItemizedSetOrder,
                $incentiveTargetId
            );

            // user_idのみを抽出し、重複を削除する
            return $selectionOrders->pluck('user_id')->unique()->values()->all();
        }
    }

    /**
     * 一人当たりバック金額の取得
     * @param StoreDetail $storeDetail
     * @param Menu $menu
     * @param int $userCount
     * @return int
     */
    private function getIncentiveAmount(StoreDetail $storeDetail, Menu $menu, int $userCount): int
    {
        // TODO: 単体テスト

        // 定額の場合
        if (!is_null($menu->insentive_amount)) {
            $amount = $menu->insentive_amount / $userCount;
        } elseif (!is_null($menu->insentive_persentage)) {
            // %の場合
            $amount = $menu->price *  $menu->insentive_persentage / 100 / $userCount;
        } else {
            return 0;
        }

        $calcMethod = RoundingMethod::getRoundingMethodById($storeDetail->user_incentive_rounding_method_id)['method'];
        $digit = Digit::getDigitById($storeDetail->user_incentive_rounding_method_id)[$calcMethod];

        if (
            $calcMethod === RoundingMethod::ROUND_UP['method']
            || $calcMethod === RoundingMethod::ROUND_DOWN['method']
            )
        {
            return $calcMethod($amount / $digit) * $digit;
        }

        if ($calcMethod === RoundingMethod::ROUND_TO_NEAREST['method']) {
            return $calcMethod($amount, $digit);
        }

        return $amount;
    }

    /**
     * 注文情報を更新する
     * @param StoreDetail $storeDetail
     * @param int $itemizedOrderId
     * @param array $oldOrderIds
     * @param int $quantity
     * @param int $adjustAmount
     * @param ?int $newUserIncentiveAmount
     * @param int $sysMenuCategoryId
     */
    public function updateOrder(
        StoreDetail $storeDetail,
        int $itemizedOrderId,
        array $oldOrderIds,
        int $quantity,
        int $adjustAmount,
        ?int $newUserIncentiveAmount,
        int $sysMenuCategoryId
    ) {
        // 新規orderの作成要否
        $modifiedQuantity = $this->getModifiedQuanity(count($oldOrderIds), $quantity);

        // 金額調整の有無を確認
        $order = $this->orderRepo->find($oldOrderIds[0]);
        $menu = $this->menuRepo->find($order->menu_id);
        $latestModifiedOrder = $this->modifiedOrderRepo->getLatestModifiedOrder($order);
        $menuAmount = ($latestModifiedOrder) ? $latestModifiedOrder->modified_amount : $menu->price;

        // 増減なし、金額変更なし
        if ($modifiedQuantity === 0 && $menuAmount === $adjustAmount) {
            $this->adjustUserIncentiveAmount($oldOrderIds, $newUserIncentiveAmount);
            return;
        }

        // 数量増減なし、メニュー金額変更あり
        if ($modifiedQuantity === 0 && $menuAmount !== $adjustAmount) {
            $modifiedOrderData = [];

            // 既存分
            foreach ($oldOrderIds as $key => $orderId) {
                $modifiedOrderData[] = [
                    'order_id' => $orderId,
                    'modified_amount' => $adjustAmount,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }

            $this->modifiedOrderRepo->insertModifiedOrder($modifiedOrderData);

            // UserIncentiveを調整
            $this->adjustUserIncentiveAmount($oldOrderIds, $newUserIncentiveAmount);
            return;
        }


        // 数量が減る
        if ($modifiedQuantity < 0) {
            // 既存の削除
            $deleteCount = abs($modifiedQuantity);

            for ($i = 0; $i < $deleteCount; $i++) {
                $lastOrderId = array_pop($oldOrderIds);

                $this->orderRepo->softDelete($lastOrderId);
            }

            // 金額調整がある場合
            if ($menuAmount !== $adjustAmount) {
                // 金額変更あり
                $modifiedOrderData = [];

                foreach ($oldOrderIds as $orderId) {
                    $modifiedOrderData[] = [
                        'order_id' => $orderId,
                        'modified_amount' => $adjustAmount,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }

                $this->modifiedOrderRepo->insertModifiedOrder($modifiedOrderData);
            }

            // UserIncentiveを調整
            $this->adjustUserIncentiveAmount($oldOrderIds, $newUserIncentiveAmount);

            return;
        }

        // 数量が増える場合
        if ($modifiedQuantity > 0) {
            $newOrders = collect();

            if (
                $sysMenuCategoryId === SysMenuCategory::CATEGORIES['FIRST_SET']['id'] ||
                $sysMenuCategoryId === SysMenuCategory::CATEGORIES['EXTENSION_SET']['id']
            ) {
                // セットメニュー
                for ($addOrderCount = 0; $addOrderCount < $modifiedQuantity; $addOrderCount++) {
                    $newOrders->push(
                        $this->orderRepo->createOrder([
                            'itemized_order_id' => $itemizedOrderId,
                            'menu_id' => $menu->id,
                        ])
                    );
                }
            } else {
                // 注文に紐づくユーザーインセンティブ取得
                $oldUserIncentive = $this->userIncentiveRepo->getOrdersUserIncentives([$oldOrderIds[0]]);
                if ($oldUserIncentive->isEmpty()) {
                    $incentiveTargetType = UserIncentive::INCENTIVE_TARGET['NONE']['type'];
                    $incentiveTargetId = 0;
                } else {
                    $incentiveTargetType = UserIncentive::INCENTIVE_TARGET['USER']['type'];
                    $incentiveTargetId = $oldUserIncentive->first()->user_id;
                }

                // 新規レコードを作成する
                $newOrders = $this->createOrders(
                    $storeDetail,
                    $itemizedOrderId,
                    $menu->id,
                    $modifiedQuantity,
                    $incentiveTargetType,
                    $incentiveTargetId
                );
            }

            $orderIdsToajustUserIncentive = [];

            $orderIdsToajustUserIncentive = $newOrders->pluck('id')->toArray();

            // メニュー金額変更がある場合
            if ($menuAmount !== $adjustAmount) {
                // 金額変更ある場合、既存分と新規分の調整後注文レコードを作成する
                $modifiedOrderData = [];

                // 既存分
                foreach ($oldOrderIds as $orderId) {
                    $modifiedOrderData[] = [
                        'order_id' => $orderId,
                        'modified_amount' => $adjustAmount,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }

                // 新規分
                foreach ($newOrders as $key => $order) {
                    $modifiedOrderData[] = [
                        'order_id' => $order->id,
                        'modified_amount' => $adjustAmount,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }

                $this->modifiedOrderRepo->insertModifiedOrder($modifiedOrderData);
            }

            $orderIdsToajustUserIncentive = array_merge($orderIdsToajustUserIncentive, $oldOrderIds);

            $this->adjustUserIncentiveAmount($orderIdsToajustUserIncentive, $newUserIncentiveAmount);
            return;
        }
    }


    private function getModifiedQuanity(int $oldQuantity, int $newQuantity){
        return $newQuantity - $oldQuantity;
    }

    /**
     * userIncetiveAmountの金額を調整する
     * @param array $ordersIds
     * @param ?int $newUserIncentiveAmount
     */
    private function adjustUserIncentiveAmount($ordersIds, ?int $newUserIncentiveAmount)
    {
        if (is_null($newUserIncentiveAmount)) {
            return;
        }

        // 注文に紐づくユーザーインセンティブ取得
        $oldUserIncentives = $this->userIncentiveRepo->getOrdersUserIncentives($ordersIds);

        // ユーザーインセンティブ金額変更なし
        if($oldUserIncentives->first()->amount === $newUserIncentiveAmount){
            return;
        }

        // ユーザーインセンティブ金額変更あり
        foreach ($oldUserIncentives as $oldUserIncentive) {
            // 新レコード作成
            $this->userIncentiveRepo->createUserIncentive([
                'order_id' => $oldUserIncentive->order_id,
                'user_id' => $oldUserIncentive->user_id,
                'amount' => $newUserIncentiveAmount
            ]);

            // 旧レコード論理削除
            $this->userIncentiveRepo->softDeletes($oldUserIncentive);
        }
    }



}
