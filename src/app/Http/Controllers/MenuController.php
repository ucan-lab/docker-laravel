<?php

namespace App\Http\Controllers;

use App\Http\Requests\Menu\MenuRequest;
use App\Http\Requests\StoreIdRequest;
use Illuminate\Support\Facades\DB;
use App\Log\CustomLog;
use Illuminate\Auth\Access\AuthorizationException;
use App\Repositories\{
    MenuCategoryRepository\MenuCategoryRepositoryInterface,
    MenuRepository\MenuRepositoryInterface,
    StoreRepository\StoreRepositoryInterface,
};
use App\Models\{
    Menu,
    SysMenuCategory
};

class MenuController extends Controller
{
    public function __construct(
        public readonly MenuCategoryRepositoryInterface $menuCategoryRepo,
        public readonly MenuRepositoryInterface $menuRepo,
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
            $this->authorize('viewAny', [Menu::class, $store]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // メニューカテゴリを取得
        $menus = $this->menuRepo->getMenuListByStoreAndSysMenuCategoryIds($store, SysMenuCategory::CATEGORIES['DRINK_FOOD']['id']);

        return response()->json([
            'status' => 'success',
            'data' => $menus
        ], 200);
    }

    public function store(MenuRequest $request)
    {
        // メニューカテゴリの取得
        $menuCategory = $this->menuCategoryRepo->find($request->menu['menu_category_id']);
        if (is_null($menuCategory)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['メニューカテゴリー情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($menuCategory->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('store', [Menu::class, $store, $request->menu['menu_category_id']]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        $this->menuRepo->createMenu($request->menu);

        return response()->json([
            'status' => 'success',
            'data' => []
        ], 200);
    }

    public function get(int $id)
    {
        // メニューの取得
        $menu = $this->menuRepo->find($id);
        if (is_null($menu)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['メニュー情報の読み込みができませんでした']
            ], 404);
        }

        // メニューカテゴリの取得
        $menuCategory = $this->menuCategoryRepo->find($menu->menu_category_id);
        if (is_null($menuCategory)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['メニューカテゴリー情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($menuCategory->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('viewAny', [Menu::class, $store]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        $menu->store_id = $store->id;

        return response()->json([
            'status' => 'success',
            'data' => $menu
        ], 200);
    }

    public function update(MenuRequest $request, int $id)
    {
        // メニューの取得
        $menu = $this->menuRepo->find($id);
        if (is_null($menu)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['メニュー情報の読み込みができませんでした']
            ], 404);
        }

        // メニューカテゴリの取得
        $menuCategory = $this->menuCategoryRepo->find($menu->menu_category_id);
        if (is_null($menuCategory)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['メニューカテゴリー情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($menuCategory->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('update', [Menu::class, $store, $menu, $request->menu['menu_category_id']]);
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
            $this->menuRepo->softDeleteMenu($menu);

            // 新しいレコードを新規作成する
            $this->menuRepo->createMenu($request->menu);

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
        // メニューの取得
        $menu = $this->menuRepo->find($id);
        if (is_null($menu)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['メニュー情報の読み込みができませんでした']
            ], 404);
        }

        // メニューカテゴリの取得
        $menuCategory = $this->menuCategoryRepo->find($menu->menu_category_id);
        if (is_null($menuCategory)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['メニューカテゴリー情報の読み込みができませんでした']
            ], 404);
        }

        // ストアの取得
        $store = $this->storeRepo->findStore($menuCategory->store_id);
        if (is_null($store)) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['ストア情報の読み込みができませんでした']
            ], 404);
        }

        // Policy確認
        try {
            $this->authorize('delete', [Menu::class, $store, $menu->menu_category_id]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['この操作を実行する権限がありません']
            ], 403);
        }

        // レコードを論理削除する
        $this->menuRepo->softDeleteMenu($menu);

        return response()->json([
            'status' => 'success',
            'data' => []
        ], 200);
    }
}
