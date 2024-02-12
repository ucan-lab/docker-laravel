<?php

namespace App\Repositories\BillPaymentRepository;

use Illuminate\Support\Collection;
use App\Models\{
    BillPayment,
    Bill,
};

interface BillPaymentRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 伝票の支払いを登録する
     * @param array $data
     * @return bool
     */
    public function insertBillPayment(array $data): bool;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 支払い伝票を取得する
     * @param Bill $bill
     * @return Collection
     */
    public function getBillPayments(Bill $bill): Collection;

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * 支払い伝票を論理削除する
     * @param BillPayment $billPayment
     * @return bool
     */
    public function softDeleteBillPayment(BillPayment $billPayment);

    /***********************************************************
     * その他
     ***********************************************************/
}
