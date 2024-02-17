<?php

namespace App\Repositories\PaymentMethodRepository;

use Illuminate\Support\Collection;
use App\Models\{
    PaymentMethod,
    Store
};

interface PaymentMethodRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 支払い方法を作成する
     *
     * @param array $data 作成に必要なデータ
     * @return PaymentMethod 作成された支払い方法
     */
    public function createPaymentMethod(array $data): PaymentMethod;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 店舗の支払い方法一覧を取得
     * @param Store $store
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getStorePaymentMethods(Store $store, $columns = array('*'), string $orderBy = 'code', string $sortBy = 'asc'): Collection;

    /**
     * ID指定で取得
     * @param int $id
     *
     * @return ?PaymentMethod
     */
    public function find(int $id): ?PaymentMethod;

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * 支払い方法をソフトデリートする
     * @param PaymentMethod $menuCategory
     * @return void
     */
    public function softDeletePaymentMethod(PaymentMethod $menuCategory): void;

    /***********************************************************
     * その他
     ***********************************************************/
}
