<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Log\CustomLog;
use App\Http\Requests\{
    PaymentMethod\PaymentMethodRequest,
    StoreIdRequest
};
use App\Models\{
    Store,
    PaymentMethod
};
use App\Repositories\{
    PaymentMethodRepository\PaymentMethodRepositoryInterface,
    SysPaymentMethodCategoryRepository\SysPaymentMethodCategoryRepositoryInterface,
    StoreRepository\StoreRepositoryInterface
};
use Illuminate\Auth\Access\AuthorizationException;

class PaymentMethodController extends Controller
{
    public function __construct(
        public readonly PaymentMethodRepositoryInterface $paymentMethodRepo,
        public readonly SysPaymentMethodCategoryRepositoryInterface $sysPaymentMethodCategoryRepo,
        public readonly StoreRepositoryInterface $storeRepo,
    ) {}

    public function getAll(StoreIdRequest $request)
    {
        // ストアの取得
        $store = $this->storeRepo->findStore($request->storeId);

        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('viewAny', [PaymentMethod::class, $store]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // 支払い方法を取得
        $paymentMethods = $this->paymentMethodRepo->getStorePaymentMethods($store);

        return response()->json([
            'status' => 'success',
            'data' => $paymentMethods
        ], 200);
    }

    public function store(PaymentMethodRequest $request)
    {
        // ストアの取得
        $store = $this->storeRepo->findStore($request->payment_method['store_id']);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('create', [PaymentMethod::class, $store, $request->payment_method['store_id']]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // 新規登録
        $this->paymentMethodRepo->createPaymentMethod($request->payment_method);

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function get(int $id)
    {
        // 支払い方法の取得
        $paymentMethod = $this->paymentMethodRepo->find($id);
        if (is_null($paymentMethod)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['支払い方法情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($paymentMethod->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('viewAny', [PaymentMethod::class, $store]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $paymentMethod
        ], 200);
    }

    public function update(PaymentMethodRequest $request, int $id)
    {
        // 支払い方法の取得
        $paymentMethod = $this->paymentMethodRepo->find($id);
        if (is_null($paymentMethod)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['支払い方法情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($paymentMethod->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('update', [PaymentMethod::class, $store, $paymentMethod, $request->payment_method['store_id']]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // トランザクションを開始する
        DB::beginTransaction();

        try {
            // 現在のレコードを論理削除する
            $this->paymentMethodRepo->softDeletePaymentMethod($paymentMethod);

            // 新しいレコードを新規作成する
            $this->paymentMethodRepo->createPaymentMethod($request->payment_method);

            DB::commit();
        } catch (\Throwable $e) {
            // 例外が発生した場合はロールバックする
            DB::rollback();

            // ログの出力
            CustomLog::error($e);

            return response()->json([
                'status' => 'failure',
                'errors' => [$e->getMessage()]
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => []
        ], 200);
    }

    public function archive(int $id)
    {
        // 支払い方法の取得
        $paymentMethod = $this->paymentMethodRepo->find($id);
        if (is_null($paymentMethod)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['支払い方法情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($paymentMethod->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('delete', [PaymentMethod::class, $store, $paymentMethod]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // 現在のレコードを論理削除する
        $this->paymentMethodRepo->softDeletePaymentMethod($paymentMethod);

        return response()->json([
            'status' => 'success',
            'data' => []
        ], 200);
    }











    /**
     * Display a listing of the resource.
     */
    public function index(Store $store)
    {
        // Policy確認
        $this->authorize('viewAny', [PaymentMethod::class, $store]);



        return view('payment_method.index', compact('paymentMethods', 'store'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Store $store)
    {
        // Policy確認
        $this->authorize('create', [PaymentMethod::class, $store, $store->id]);

        // システム支払い方法一覧を取得
        $sysPaymentMethodCategories = $this->sysPaymentMethodCategoryRepo->getSysPaymentMethodCategories();

        return view('payment_method.create', compact('sysPaymentMethodCategories', 'store'));
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store, PaymentMethod $paymentMethod)
    {
        // Policy確認
        $this->authorize('update', [PaymentMethod::class, $store, $paymentMethod, $store->id]);

        // システム支払い方法一覧を取得
        $sysPaymentMethodCategories = $this->sysPaymentMethodCategoryRepo->getSysPaymentMethodCategories();

        return view('payment_method.edit', compact('sysPaymentMethodCategories', 'paymentMethod', 'store'));
    }

    /**
     * Update the specified resource in storage.
     */



}
