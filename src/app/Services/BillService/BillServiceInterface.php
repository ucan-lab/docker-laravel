<?php

namespace App\Services\BillService;

use Illuminate\Support\Collection;
use App\Models\{
    Store
};

interface BillServiceInterface
{
    /**
     * ホールに表示するテーブル一覧(伝票情報含む)を取得
     * @param Store $store
     * @return Collection
     */
    function getAllDisplayTablesWithStatus(Store $store);
}
