<?php

namespace App\Repositories\MenuRepository;

use Illuminate\Support\Collection;
use App\Models\{
    Menu,
    Store,
    MenuCategory,
};

interface MenuRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * メニューカテゴリを作成する
     *
     * @param array $data 作成に必要なデータ
     * @return Menu 作成されたメニュー
     */
    public function createMenu(array $data): Menu;

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
    public function getMenuListByStoreAndSysMenuCategoryIds(Store $store, int|array $sysMenuCategoryIds, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    /**
     * 店舗と指定したsysMenuCategoryIDに紐づく表示メニュー一覧を取得
     * @param Store $store
     * @param int|array $sysMenuCategoryIds
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getDisplayMenuListByStoreAndSysMenuCategoryIds(Store $store, int|array $sysMenuCategoryIds, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    /**
     * MenuCategoryに紐づく表示メニュー一覧を取得
     * @param MenuCategory $menuCategory
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getDisplayMenusByMenuCategory(MenuCategory $menuCategory, $columns = array('*'), string $orderBy = 'name', string $sortBy = 'asc');

    /**
     * ID指定でMenuを取得
     * @param int $id
     * @return Menu
     */
    public function find(int $id): Menu;

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
    public function softDeleteMenu(Menu $menu): void;

    /***********************************************************
     * その他
     ***********************************************************/
}
