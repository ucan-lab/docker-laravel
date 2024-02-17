<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Log\CustomLog;
use App\Http\Requests\{
    Table\TableRequest,
    StoreIdRequest
};
use App\Models\{
    Store,
    Table
};
use App\Repositories\{
    TableRepository\TableRepositoryInterface,
    StoreRepository\StoreRepositoryInterface
};
use Illuminate\Auth\Access\AuthorizationException;

class TableController extends Controller
{
    public function __construct(
        public readonly TableRepositoryInterface $tableRepo,
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
            $this->authorize('viewAny', [Table::class, $store]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // 卓を取得
        $tables = $this->tableRepo->getAllTables($store);

        return response()->json([
            'status' => 'success',
            'data' => $tables
        ], 200);
    }

    public function store(TableRequest $request)
    {
        // ストアの取得
        $store = $this->storeRepo->findStore($request->table['store_id']);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('create', [Table::class, $store, $request->table['store_id']]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // 新規登録
        $table = $this->tableRepo->createTable($request->table);

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function get(int $id)
    {
        // 卓の取得
        $table = $this->tableRepo->find($id);
        if (is_null($table)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['卓情報情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($table->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('viewAny', [Table::class, $store]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $table
        ], 200);
    }

    public function update(TableRequest $request, int $id)
    {
        // 卓の取得
        $table = $this->tableRepo->find($id);
        if (is_null($table)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['卓情報情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($table->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('update', [Table::class, $store, $table, $request->table['store_id']]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // トランザクションを開始する
        DB::beginTransaction();
        try {
            // 既存のテーブルを論理削除
            $this->tableRepo->softDeleteTable($table);

            // テーブル作成
            $table = $this->tableRepo->createTable($request->table);

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
        // 卓の取得
        $table = $this->tableRepo->find($id);
        if (is_null($table)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['卓情報情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($table->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('delete', [Table::class, $store, $table]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }


        $this->tableRepo->softDeleteTable($table);

        return response()->json([
            'status' => 'success',
            'data' => []
        ], 200);
    }
}
