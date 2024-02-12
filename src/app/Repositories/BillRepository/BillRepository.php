<?php

namespace App\Repositories\BillRepository;

use App\Models\{
    Bill,
    Table,
    BusinessDate,
    Store
};
use Illuminate\Support\Collection;

class BillRepository implements BillRepositoryInterface
{
    private $model;

    public function __construct(Bill $bill)
    {
        $this->model = $bill;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 伝票レコードを作成する
     * @param array $data
     * @return Bill
     */
    public function createBill(array $data): Bill
    {
        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 伝票を取得
     * @param int $id
     * @return Bill
     */
    public function find(int $id): Bill
    {
        return $this->model->find($id);
    }

    /**
     * 現在のテーブルに紐づく伝票を取得
     * @param Table $table
     * @return ?Bill
     */
    public function getCurrentTableBill(Table $table): ?Bill
    {
        return $table->bills->where('departure_time', null)->first();
    }

    /**
     * ItemizedOrderIdの属する伝票を取得
     * @param int $itemizedOrderId
     * @return Bill
     */
    public function getBillByItemizedOrderId(int $itemizedOrderId): Bill
    {
        return $this->model->whereHas('itemizedOrders', function($query) use ($itemizedOrderId) {
            $query->where('id', $itemizedOrderId);

        })
        ->first();
    }

    /**
     * @param Store $store
     * @param BusinessDate $businessDate
     *
     * @return Collection
     */
    public function getBusinessDateBills(Store $store, BusinessDate $businessDate): Collection
    {
        return $this->model->where('business_date_id', $businessDate->id)
            ->where('store_id', $store->id)
            ->get();
    }

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * 伝票レコードを更新する
     * @param Bill $bill
     * @return bool
     */
    public function updateBill(Bill $bill): bool
    {
        return $bill->save();
    }

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * 伝票をアーカイブ
     * @param Bill $bill
     * @return bool
     */
    public function softDeleteBill(Bill $bill): bool
    {
        return $bill->delete();
    }

    /***********************************************************
     * その他
     ***********************************************************/
    /**
     * テーブルに伝票情報にアタッチ
     * @param Bill $bill
     * @param array $tableIds
     * @return void
     */
    public function attachTablesToBill(Bill $bill, array $tableIds): void
    {
        $bill->tables()->attach($tableIds);
    }
}
