<?php

namespace App\Repositories\CashRegisterRepository;

use App\Models\{
    CashRegister,
    BusinessDate,
};
use Illuminate\Support\Collection;

class CashRegisterRepository implements CashRegisterRepositoryInterface
{
    private $model;

    public function __construct(CashRegister $businessDate)
    {
        $this->model = $businessDate;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * レジ金を登録する
     * @param BusinessDate $businessDate
     * @param array $data
     * @return CashRegister
     */
    public function createCashRegister(BusinessDate $businessDate, array $data): CashRegister
    {
        // $dataに営業日付IDを付与
        $data['business_date_id'] = $businessDate->id;
        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 営業日に紐づくレジ金情報を取得
     * @param BusinessDate $businessDate
     *
     * @return CashRegister
     */
    public function getBusinessDateCashRegister(BusinessDate $businessDate): CashRegister
    {
        return $businessDate->cashRegister;
    }

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * @param int $businessDateId
     * @param array $data
     *
     * @return bool
     */
    public function updateCashRegisterByBusinessDateId(int $businessDateId, array $data): bool
    {
        return $this->model->where('business_date_id', $businessDateId)->update($data);
    }

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/

}
