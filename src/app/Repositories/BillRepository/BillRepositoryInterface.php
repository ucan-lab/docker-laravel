<?php

namespace App\Repositories\BillRepository;

use App\Models\{
    Bill,
    Table,
    BusinessDate,
    Store
};
use Illuminate\Support\Collection;

interface BillRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 勤退記録親レコードを作成する
     * @param array $data
     * @return Bill
     */
    public function createBill(array $data): Bill;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 伝票を取得
     * @param int $id
     * @return Bill
     */
    public function find(int $id): Bill;

    /**
     * 現在のテーブルに紐づく伝票を取得
     * @param Table $table
     * @return ?Bill
     */
    public function getCurrentTableBill(Table $table): ?Bill;

    /**
     * ItemizedOrderIdの属する伝票を取得
     * @param int $itemizedOrderId
     * @return Bill
     */
    public function getBillByItemizedOrderId(int $itemizedOrderId): Bill;

    /**
     * @param Store $store
     * @param BusinessDate $businessDate
     *
     * @return Collection
     */
    public function getBusinessDateBills(Store $store, BusinessDate $businessDate): Collection;

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * 伝票レコードを更新する
     * @param Bill $bill
     * @return bool
     */
    public function updateBill(Bill $bill): bool;

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * 伝票をアーカイブ
     * @param Bill $bill
     * @return bool
     */
    public function softDeleteBill(Bill $bill): bool;

    /***********************************************************
     * その他
     ***********************************************************/
    /**
     * テーブルに伝票情報にアタッチ
     * @param Bill $bill
     * @param array $tableIds
     * @return void
     */
    public function attachTablesToBill(Bill $bill, array $tableIds): void;
}
