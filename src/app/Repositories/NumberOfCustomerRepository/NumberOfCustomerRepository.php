<?php

namespace App\Repositories\NumberOfCustomerRepository;

use App\Models\{
    NumberOfCustomer,
    Bill,
};
use Illuminate\Support\Facades\DB;

class NumberOfCustomerRepository implements NumberOfCustomerRepositoryInterface
{
    private $model;

    public function __construct(NumberOfCustomer $numberOfCustomer)
    {
        $this->model = $numberOfCustomer;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 来店時客数レコードの作成
     * @param int $billId
     * @param int $arrival
     * @return NumberOfCustomer
     */
    public function createNumberOfCustomer(int $billId, int $arrival): NumberOfCustomer
    {
        return $this->model->create([
            'bill_id' => $billId,
            'arrival' => $arrival
        ]);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 伝票に紐づく客数を取得
     * @param Bill $bill
     * @return NumberOfCustomer
     */
    public function getBillNumberOfCustomer(Bill $bill): NumberOfCustomer
    {
        return $bill->numberOfCustomer;
    }

    /**
     * 伝票一覧に紐づく客数
     * @param array $billIds
     * @return int
     */
    public function getBillsNumberOfCustomer(array $billIds): int
    {
        if (empty($billIds)) {
            return 0;
        }

        return $this->model->whereIn('bill_id', $billIds)
            ->select(DB::raw('SUM(arrival + "join") as total_sum'))->first()->total_sum;
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
