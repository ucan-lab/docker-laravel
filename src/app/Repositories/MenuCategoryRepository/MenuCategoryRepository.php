<?php

namespace App\Repositories\MenuCategoryRepository;

use App\Models\{
    MenuCategory,
    Store,
    Menu,
};
use Illuminate\Support\Collection;

class MenuCategoryRepository implements MenuCategoryRepositoryInterface
{
    private $model;

    public function __construct(MenuCategory $menuCategory)
    {
        $this->model = $menuCategory;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * メニューカテゴリを作成する
     *
     * @param array $data 作成に必要なデータ
     * @return MenuCategory 作成されたグループ
     */
    public function createMenuCategory(array $data): MenuCategory
    {
        return $this->model->create(array_filter($data));
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * 店舗のメニューカテゴリ一覧を取得
     * @param Store $store
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getMenuCategoryListByStore(Store $store, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc'): Collection
    {
        return $store->menuCategories()
            ->orderBy($orderBy, $sortBy)
            ->get($columns);
    }

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
    public function getMenuCategoryListByStoreAndSysMenuCategoryIds(Store $store, int|array $sysMenuCategoryIds, $columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): collection
    {
        $query = $store->menuCategories();

        if (is_array($sysMenuCategoryIds)) {
            $query = $query->whereIn('sys_menu_category_id', $sysMenuCategoryIds);
        } else {
            $query = $query->where('sys_menu_category_id', $sysMenuCategoryIds);
        }

        return $query->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * 指定したIDのメニューカテゴリを取得する
     * @param int $id
     * @return MenuCategory
     */
    public function findOrFail(int $id): MenuCategory
    {
        return $this->model->findOrFail($id);
    }

    /**
     * TODO: 上の挙動考える
     * 指定したIDのメニューカテゴリを取得する
     * @param int $id
     * @return ?MenuCategory
     */
    public function find(int $id): ?MenuCategory
    {
        return $this->model->find($id);
    }

    /**
     * メニューの属するメニューカテゴリを取得する
     * @param Menu $menu
     * @return MenuCategory
     */
    public function getMenuMenuCategory(Menu $menu): MenuCategory
    {
        return $menu->menuCategory;
    }

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
    public function softDeleteMenuCategory(MenuCategory $menuCategory): void
    {
        $menuCategory->delete();
    }

    /***********************************************************
     * その他
     ***********************************************************/

}
