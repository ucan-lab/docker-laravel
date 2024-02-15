<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Log\CustomLog;
use App\Http\Requests\MenuCategory\MenuCategoryRequest;
use App\Repositories\{
    MenuCategoryRepository\MenuCategoryRepositoryInterface,
    StoreRepository\StoreRepositoryInterface
};
use App\Models\{
    MenuCategory,
    Store,
    SysMenuCategory,
};
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class MenuCategoryController extends Controller
{
    public function __construct(
        public readonly MenuCategoryRepositoryInterface $menuCategoryRepo,
        public readonly StoreRepositoryInterface $storeRepo,
    ) {}

    public function getAll(Request $request)
    {
        // リクエストバリデーション
        try {
            $request->validate([
                'storeId' => 'required|integer'
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 400);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($request->storeId);

        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 500);
        }

        // Policy確認
        try {
            $this->authorize('viewAny', [MenuCategory::class, $store]);
        } catch (AuthorizationException $e) {
            return response([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // メニューカテゴリを取得
        $menuCategories = $this->menuCategoryRepo->getMenuCategoryListByStore($store);

        return response()->json([
            'status' => 'success',
            'data' => $menuCategories
        ], 200);
    }

    public function create(Store $store)
    {
        // Policy確認
        $this->authorize('create', [MenuCategory::class, $store, $store->id]);

        // システムメニューカテゴリを一覧取得
        $sysMenuCategories = SysMenuCategory::get();

        return view('menu_category.create',compact('sysMenuCategories', 'store'));
    }

    public function store(MenuCategoryRequest $request, Store $store)
    {
        // Policy確認
        $this->authorize('create', [MenuCategory::class, $store, $request->menu_category['store_id']]);

        // 新規登録
        $this->menuCategoryRepo->createMenuCategory($request->menu_category);

        return redirect()->route('menu-categories.index', ['store' => $store->id])->with([
            'message'=> '新規作成しました。',
        ]);
    }

    public function edit(Store $store, MenuCategory $menuCategory)
    {
        // Policy確認
        $this->authorize('update', [MenuCategory::class, $store, $menuCategory->store_id, $menuCategory->store_id]);

        // システムメニューカテゴリを一覧取得
        $sysMenuCategories = SysMenuCategory::get();

        return view('menu_category.edit',compact('sysMenuCategories', 'menuCategory', 'store'));
    }

    public function update(MenuCategoryRequest $request, Store $store, MenuCategory $menuCategory)
    {
        // Policy確認
        $this->authorize('update', [MenuCategory::class, $store, $request->menu_category['store_id'], $menuCategory->store_id]);

        // トランザクションを開始する
        DB::beginTransaction();

        try {
            // 現在のレコードを論理削除する
            $this->menuCategoryRepo->softDeleteMenuCategory($menuCategory);

            // 新しいレコードを新規作成する
            $this->menuCategoryRepo->createMenuCategory($request->menu_category);

            DB::commit();
        } catch (\Throwable $e) {
            // 例外が発生した場合はロールバックする
            DB::rollback();

            // ログの出力
            CustomLog::error($e);

            abort(500);
        }

        return redirect()->route('menu-categories.index', ['store' => $store->id])->with([
            'message'=> $menuCategory->name . 'を更新しました。',
        ]);
    }

    public function destroy(string $id)
    {
        //
    }

    public function archive(Store $store, MenuCategory $menuCategory)
    {
        // Policy確認
        $this->authorize('delete', [MenuCategory::class, $store, $menuCategory->store_id]);

        // レコードを論理削除する
        $this->menuCategoryRepo->softDeleteMenuCategory($menuCategory);

        return redirect()->route('menu-categories.index', ['store' => $store->id])->with([
            'message'=> $menuCategory->name . 'を削除しました。',
        ]);
    }
}
