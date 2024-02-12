<?php

namespace App\Services\BillService;

use Illuminate\Support\Collection;
use App\Services\BillService\BillServiceInterface;
use App\Models\{
    Store
};
use App\Repositories\{
    BillRepository\BillRepositoryInterface,
    TableRepository\TableRepositoryInterface,
    ItemizedOrderRepository\ItemizedOrderRepositoryInterface,
    OrderRepository\OrderRepositoryInterface,
    NumberOfCustomerRepository\NumberOfCustomerRepositoryInterface,
    BillPaymentRepository\BillPaymentRepositoryInterface,
};

class BillService implements BillServiceInterface
{
    public function __construct(
        public readonly BillRepositoryInterface $billRepo,
        public readonly TableRepositoryInterface $tableRepo,
        public readonly ItemizedOrderRepositoryInterface $itemizedOrderRepo,
        public readonly OrderRepositoryInterface $orderRepo,
        public readonly NumberOfCustomerRepositoryInterface $numberOfCustomerRepo,
        public readonly BillPaymentRepositoryInterface $billPaymentRepo,
    ) {
    }

    /**
     * ホールに表示するテーブル一覧(伝票情報含む)を取得
     * @param Store $store
     * @return Collection
     */
    function getAllDisplayTablesWithStatus(Store $store)
    {
        // TODO: リファクタ
        // 表示テーブル一覧を取得
        $tables = $this->tableRepo->getAllDisplayTables($store);

        foreach ($tables as $table_i => $table) {
            // 伝票情報取得
            $tables[$table_i]['bill'] = $this->billRepo->getCurrentTableBill($table);

            if (is_null($tables[$table_i]['bill'])) {
                continue;
            }
            // 伝票の支払い情報を取得
            $tables[$table_i]['bill']['billPayments'] = $this->billPaymentRepo->getBillPayments($tables[$table_i]['bill']);

            // 伝票に紐づく一連の注文を取得
            $tables[$table_i]['bill']['itemizedOrders'] = $this->itemizedOrderRepo->getBillItemizedOrders($tables[$table_i]['bill']);

            // 一連の注文に紐づくオーダーを取得
            foreach ($tables[$table_i]['bill']['itemizedOrders'] as $itemizedOrder_i => $itemizedOrder) {
                $tables[$table_i]['bill']['itemizedOrders'][$itemizedOrder_i]['orders']
                    = $this->orderRepo->getItemizedOrderOrders($itemizedOrder);
            }

            // dd($tables);

            // 伝票に紐づく客数を取得
            $tables[$table_i]['bill']['numberOfCustomer'] =
                $this->numberOfCustomerRepo->getBillNumberOfCustomer($tables[$table_i]['bill']);

        }

        return $tables;
    }
}
