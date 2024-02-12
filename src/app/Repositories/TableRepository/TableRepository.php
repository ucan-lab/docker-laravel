<?php

namespace App\Repositories\TableRepository;

use Illuminate\Support\Collection;
use App\Repositories\TableRepository\TableRepositoryInterface;
use App\Models\{
    Table,
    Store
};

class TableRepository implements TableRepositoryInterface
{
    public function __construct(Table $store)
    {
        $this->model = $store;
    }

    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * テーブルを新規作成する
     * @param array $data 新規テーブルデータ
     * @return Table
     */
    public function createTable(array $data): Table
    {
        return $this->model->create($data);
    }

    /***********************************************************
     * Read系
     ***********************************************************/
    /**
     * ストアに属するテーブル一覧を取得する
     * @param Store $store ストア
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getAllTables(Store $store, string $orderBy = 'name', string $sortBy = 'asc'): Collection
    {
        return $store->tables()
            ->orderBy($orderBy, $sortBy)
            ->get();
    }

    /**
     * ストアに属する表示テーブル一覧を取得する
     * @param Store $store ストア
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getAllDisplayTables(Store $store, string $orderBy = 'name', string $sortBy = 'asc'): Collection
    {
        return $store->tables()
            ->where('display', true)
            ->orderBy($orderBy, $sortBy)
            ->get();
    }

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * テーブル情報を更新する
     * @param Table $table 更新前テーブル
     * @param array $data 更新情報
     * @return bool
     */
    public function updateTable(Table $table, array $data): bool
    {
        return $table->update($data);
    }

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * テーブルをソフトデリートする
     * @param Table $table
     * @return void
     */
    public function softDeleteTable(Table $table): void
    {
        $table->delete();
    }

    /***********************************************************
     * その他
     ***********************************************************/
}
