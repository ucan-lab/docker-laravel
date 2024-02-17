<?php

namespace App\Http\Controllers;

use App\Models\BusinessDate;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIdRequest;
use Illuminate\Support\Facades\DB;
use App\Log\CustomLog;
use App\Models\{
    Store,
};
use App\Repositories\{
    BusinessDateRepository\BusinessDateRepositoryInterface,
    CashRegisterRepository\CashRegisterRepositoryInterface,
    StoreRepository\StoreRepositoryInterface,
};
use App\Http\Requests\OpeningPreparation\OpeningPreparationRequest;
use Illuminate\Auth\Access\AuthorizationException;

class OpeningPreparationController extends Controller
{
    public function __construct(
        public readonly BusinessDateRepositoryInterface $businessDateRepo,
        public readonly CashRegisterRepositoryInterface $cashRegisterRepo,
        public readonly StoreRepositoryInterface $storeRepo,
    ) {}

    public function get(StoreIdRequest $request)
    {
        // ストアの取得
        $store = $this->storeRepo->findStore($request->storeId);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // 営業日付を取得
        $businessDate = $this->businessDateRepo->getCurrentBusinessDate($store);
        if (!$businessDate) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['営業情報の読み込みができませんでした']
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $businessDate
        ], 200);
    }

    public function store(OpeningPreparationRequest $request)
    {
        // ストアの取得
        $store = $this->storeRepo->findStore($request->business_date['store_id']);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('create', [BusinessDate::class, $store, $request->business_date['store_id']]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // トランザクションを開始する
        DB::beginTransaction();

        try {
        // 営業日付の登録
        $businessDate = $this->businessDateRepo->createBusinessDate($request->business_date);

        // 釣銭準備金の登録
        $this->cashRegisterRepo->createCashRegister($businessDate, $request->cash_register);

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
}
