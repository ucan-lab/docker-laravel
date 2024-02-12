<?php

namespace App\Repositories\NumberOfCustomerRepository;

use App\Models\{
    NumberOfCustomer,
    Bill,
};

interface NumberOfCustomerRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 来店時客数レコードの作成
     * @param int $billId
     * @param int $arrival
     * @return NumberOfCustomer
     */
    public function createNumberOfCustomer(int $billId, int $arrival): NumberOfCustomer;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 伝票に紐づく客数を取得
     * @param Bill $bill
     * @return NumberOfCustomer
     */
    public function getBillNumberOfCustomer(Bill $bill): NumberOfCustomer;

    /**
     * 伝票一覧に紐づく客数
     * @param array $billIds
     * @return int
     */
    public function getBillsNumberOfCustomer(array $billIds): int;

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
