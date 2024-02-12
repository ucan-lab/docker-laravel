<?php

namespace App\Repositories\MenuRepository;

use App\Models\{
    Menu,
    Store,
    MenuCategory,
};
use Illuminate\Support\Collection;

class MenuRepository implements MenuRepositoryInterface
{
    private $model;

    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * メニューを作成する
     *
     * @param array $data 作成に必要なデータ
     * @return Menu 作成されたメニュー
     */
    public function createMenu(array $data): Menu
    {
        // デフォルトだと0もnull判定されるためdisplayのfalseが消されてDBのデフォルト値trueで登録されてしまう
        // 値が0であれば配列内の項目を削除させない
        return $this->model->create(array_filter($data, function ($value) {
            return $value !== null;
        }));
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 店舗と指定したsysMenuCategoryIDに紐づくメニュー一覧を取得
     * @param Store $store
     * @param int|array $sysMenuCategoryIds
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getMenuListByStoreAndSysMenuCategoryIds(Store $store, int|array $sysMenuCategoryIds, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->model
            ->whereHas('menuCategory', function ($query) use ($store, $sysMenuCategoryIds) {
                $query->where('store_id', $store->id);

                // セットメニューで配列で渡された場合whereInで検索
                if (is_array($sysMenuCategoryIds)) {
                    $query->whereIn('sys_menu_category_id', $sysMenuCategoryIds);
                } else {
                    $query->where('sys_menu_category_id', $sysMenuCategoryIds);
                }
            })
            ->orderBy($orderBy, $sortBy)
            ->get($columns);
    }

    /**
     * 店舗と指定したsysMenuCategoryIDに紐づく表示メニュー一覧を取得
     * @param Store $store
     * @param int|array $sysMenuCategoryIds
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getDisplayMenuListByStoreAndSysMenuCategoryIds(Store $store, int|array $sysMenuCategoryIds, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->getMenuListByStoreAndSysMenuCategoryIds($store, $sysMenuCategoryIds, $columns, 'name', $sortBy)
            ->where('display', true);
    }

    /**
     * MenuCategoryに紐づく表示メニュー一覧を取得
     * @param MenuCategory $menuCategory
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getDisplayMenusByMenuCategory(MenuCategory $menuCategory, $columns = array('*'), string $orderBy = 'name', string $sortBy = 'asc')
    {
        return $menuCategory->menus()
            ->orderBy($orderBy, $sortBy)
            ->get($columns);
    }

    /**
     * ID指定でMenuを取得
     * @param int $id
     * @return Menu
     */
    public function find(int $id): Menu
    {
        return $this->model->where('id', $id)
            ->with('setMenu')
            ->first();
    }

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * メニューをソフトデリートする
     * @param Menu $menu
     * @return void
     */
    public function softDeleteMenu(Menu $menu): void
    {
        $menu->delete();
    }

    /***********************************************************
     * その他
     ***********************************************************/

}
