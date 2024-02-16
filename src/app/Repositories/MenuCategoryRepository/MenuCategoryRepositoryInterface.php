<?php

namespace App\Repositories\MenuCategoryRepository;

use Illuminate\Support\Collection;
use App\Models\{
    MenuCategory,
    Store,
    Menu,
};

interface MenuCategoryRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * メニューカテゴリを作成する
     *
     * @param array $data 作成に必要なデータ
     * @return MenuCategory 作成されたグループ
     */
    public function createMenuCategory(array $data): MenuCategory;

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 店舗の飲食カテゴリ一覧を取得
     * @param Store $store
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getMenuCategoryListByStore(Store $store, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc'): Collection;

    /**
     * 店舗に所属するメニューカテゴリのうち、
     * 指定したシステムメニューカテゴリに該当するメニューカテゴリ一覧を取得
     * @param Store $store
     * @param int|array $sysMenuCategoryIds
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getMenuCategoryListByStoreAndSysMenuCategoryIds(Store $store, int|array $sysMenuCategoryIds, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc'): collection;

    /**
     * 指定したIDのメニューカテゴリを取得する
     * @param int $id
     * @return MenuCategory
     */
    public function findOrFail(int $id): MenuCategory;

    /**
     * TODO: 上の挙動考える
     * 指定したIDのメニューカテゴリを取得する
     * @param int $id
     * @return ?MenuCategory
     */
    public function find(int $id): ?MenuCategory;

    /**
     * メニューの属するメニューカテゴリを取得する
     * @param Menu $menu
     * @return MenuCategory
     */
    public function getMenuMenuCategory(Menu $menu): MenuCategory;

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * メニューカテゴリをソフトデリートする
     * @param MenuCategory $menuCategory
     * @return void
     */
    public function softDeleteMenuCategory(MenuCategory $menuCategory): void;

    /***********************************************************
     * その他
     ***********************************************************/
}
