<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Repositories\{
    StoreRepository\StoreRepositoryInterface,
};

class GroupController extends Controller
{
    public function __construct(
        public readonly StoreRepositoryInterface $storeRepo,
    ) {
    }

    public function getStores()
    {
        // グループの取得
        $group = auth()->user()->groups->first();

        // グループに属する店舗一覧を取得
        $stores = $this->storeRepo->getStoreListByGroup($group);

        // return view("group_dashboard.home", compact('stores'));
        return response([
            'status' => 'success',
            'data' => $stores
        ], 200);
    }
}
