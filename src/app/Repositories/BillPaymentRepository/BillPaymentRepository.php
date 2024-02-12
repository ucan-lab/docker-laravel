<?php

namespace App\Repositories\BillPaymentRepository;

use App\Models\{
    BillPayment,
    Bill,
};
use Illuminate\Support\Collection;

class BillPaymentRepository implements BillPaymentRepositoryInterface
{
    private $model;

    public function __construct(BillPayment $billPayment)
    {
        $this->model = $billPayment;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 伝票の支払いを登録する
     * @param array $data
     * @return bool
     */
    public function insertBillPayment(array $data): bool
    {
        return $this->model->insert($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 支払い伝票を取得する
     * @param Bill $bill
     * @return Collection
     */
    public function getBillPayments(Bill $bill): Collection
    {
        return $bill->billPayments;
    }

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
    public function softDeleteBillPayment(BillPayment $billPayment)
    {
        return $billPayment->delete();
    }

    /***********************************************************
     * その他
     ***********************************************************/

}
