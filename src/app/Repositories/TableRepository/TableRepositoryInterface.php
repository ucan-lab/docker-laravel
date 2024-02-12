<?php

namespace App\Repositories\TableRepository;

use Illuminate\Support\Collection;
use App\Models\{
    Table,
    Store
};

interface TableRepositoryInterface
{
    /***********************************************************
     * Create系
     ***********************************************************/
    /**
     * テーブルを新規作成する
     * @param array $data 新規テーブルデータ
     * @return Table
     */
    public function createTable(array $data): Table;

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
    public function getAllTables(Store $store, string $orderBy = 'name', string $sortBy = 'asc'): Collection;

    /**
     * ストアに属する表示テーブル一覧を取得する
     * @param Store $store ストア
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function getAllDisplayTables(Store $store, string $orderBy = 'name', string $sortBy = 'asc'): Collection;

    /***********************************************************
     * Update系
     ***********************************************************/
    /**
     * テーブル情報を更新する
     * @param Table $table 更新前テーブル
     * @param array $data 更新情報
     * @return bool
     */
    public function updateTable(Table $table, array $data): bool;

    /***********************************************************
     * Delete系
     ***********************************************************/
    /**
     * テーブルをソフトデリートする
     * @param Table $table
     * @return void
     */
    public function softDeleteTable(Table $table): void;

    /***********************************************************
     * その他
     ***********************************************************/
}
