<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    GroupController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\{
    UserController,
    SysMenuCategoryController,
    MenuCategoryController
};

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'get'])->name('user.get');


    Route::get('/group/stores', [GroupController::class, 'getStores']);

    // システムメニューカテゴリ一覧を取得
    Route::get('/sysMenuCategories', [SysMenuCategoryController::class, 'getAll']);

    // ストアに属するメニューカテゴリ
    Route::get('/menuCategories', [MenuCategoryController::class, 'getAll']);
    Route::post('/menuCategories/store', [MenuCategoryController::class, 'store']);
    Route::get('/menuCategories/{id}', [MenuCategoryController::class, 'get']);
    Route::put('/menuCategories/{id}', [MenuCategoryController::class, 'update']);
    Route::delete('/menuCategories/{id}', [MenuCategoryController::class, 'archive']);
});
