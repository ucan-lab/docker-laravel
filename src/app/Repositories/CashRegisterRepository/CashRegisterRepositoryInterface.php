<?php

namespace App\Repositories\CashRegisterRepository;

use Illuminate\Support\Collection;
use App\Models\{
    CashRegister,
    BusinessDate
};

interface CashRegisterRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * レジ金を登録する
     * @param BusinessDate $businessDate
     * @param array $data
     * @return CashRegister
     */
    public function createCashRegister(BusinessDate $businessDate, array $data): CashRegister;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 営業日に紐づくレジ金情報を取得
     * @param BusinessDate $businessDate
     *
     * @return CashRegister
     */
    public function getBusinessDateCashRegister(BusinessDate $businessDate): CashRegister;

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * @param int $businessDateId
     * @param array $data
     *
     * @return bool
     */
    public function updateCashRegisterByBusinessDateId(int $businessDateId, array $data): bool;

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/
}
