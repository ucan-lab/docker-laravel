<?php

namespace App\Repositories\SetMenuRepository;

use App\Models\{
    Menu,
    SetMenu
};
use Illuminate\Support\Collection;

class SetMenuRepository implements SetMenuRepositoryInterface
{
    private $model;

    public function __construct(SetMenu $setMenu)
    {
        $this->model = $setMenu;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * セットメニューを作成する
     * @param Menu $menu
     * @param array $data 作成に必要なデータ
     * @return SetMenu 作成されたセットメニュー
     */
    public function createSetMenu(Menu $menu, array $data): SetMenu
    {
        $data['menu_id'] = $menu->id;

        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * メニューに属するセットメニューを取得する
     * @param Menu $menu
     * @return ?SetMenu
     */
    public function getMenuSetMenu(Menu $menu): ?SetMenu
    {
        return $menu->setMenu;
    }

    /***********************************************************
     * Update系
     ***********************************************************/

    /***********************************************************
     * Delete系
     ***********************************************************/

    /***********************************************************
     * その他
     ***********************************************************/

}
