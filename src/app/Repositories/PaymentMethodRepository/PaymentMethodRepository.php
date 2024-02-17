<?php

namespace App\Repositories\PaymentMethodRepository;

use App\Models\{
    PaymentMethod,
    Store
};
use Illuminate\Support\Collection;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    private $model;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->model = $paymentMethod;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * 支払い方法を作成する
     *
     * @param array $data 作成に必要なデータ
     * @return PaymentMethod 作成された支払い方法
     */
    public function createPaymentMethod(array $data): PaymentMethod
    {
        return $this->model->create(array_filter($data));
    }

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
    public function getStorePaymentMethods(Store $store, $columns = array('*'), string $orderBy = 'sys_payment_method_category_id', string $sortBy = 'asc'): Collection
    {
        return $store->paymentMethods()
            ->orderBy($orderBy, $sortBy)
            ->get($columns);
    }

    /**
     * ID指定で取得
     * @param int $id
     *
     * @return ?PaymentMethod
     */
    public function find(int $id): ?PaymentMethod
    {
        return $this->model->find($id);
    }

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * 支払い方法をソフトデリートする
     * @param PaymentMethod $paymentMethod
     * @return void
     */
    public function softDeletePaymentMethod(PaymentMethod $paymentMethod): void
    {
        $paymentMethod->delete();
    }

    /***********************************************************
     * その他
     ***********************************************************/

}
