<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    GroupController,
    StoreController
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
    MenuCategoryController,
    MenuController,
    SetMenuController,
    SelectionMenuController,
    TableController,
    PaymentMethodController,
    SysPaymentMethodController,
};

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'get'])->name('user.get');


    Route::get('/group/stores', [GroupController::class, 'getStores']);

    // システムメニューカテゴリ一覧を取得
    Route::get('/sysMenuCategories', [SysMenuCategoryController::class, 'getAll']);

    // システム支払いカテゴリ
    Route::get('/sysPaymentMethods', [SysPaymentMethodController::class, 'getAll']);

    // ストアに属するメニューカテゴリ
    Route::prefix('/store')->group(function () {
        Route::get('/create', [StoreController::class, 'create'])->name('store.create');
    });

    // メニューカテゴリー
    Route::prefix('/menuCategories')->group(function () {
        Route::get('/', [MenuCategoryController::class, 'getAll']);
        Route::post('/', [MenuCategoryController::class, 'store']);
        Route::get('/{id}', [MenuCategoryController::class, 'get']);
        Route::put('/{id}', [MenuCategoryController::class, 'update']);
        Route::delete('/{id}', [MenuCategoryController::class, 'archive']);
    });

    // メニュー
    Route::prefix('/menus')->group(function () {
        Route::get('/', [MenuController::class, 'getAll']);
        Route::post('/', [MenuController::class, 'store']);
        Route::get('/{id}', [MenuController::class, 'get']);
        Route::put('/{id}', [MenuController::class, 'update']);
        Route::delete('/{id}', [MenuController::class, 'archive']);
    });

    // セットメニュー
    Route::prefix('/setMenus')->group(function () {
        Route::get('/', [SetMenuController::class, 'getAll']);
        Route::post('/', [SetMenuController::class, 'store']);
        Route::get('/{id}', [SetMenuController::class, 'get']);
        Route::put('/{id}', [SetMenuController::class, 'update']);
        Route::delete('/{id}', [MenuController::class, 'archive']);
    });

    // 指名メニュー
    Route::prefix('/selectionMenus')->group(function () {
        Route::get('/', [SelectionMenuController::class, 'getAll']);
        Route::post('/', [SelectionMenuController::class, 'store']);
        Route::get('/{id}', [SelectionMenuController::class, 'get']);
        Route::put('/{id}', [SelectionMenuController::class, 'update']);
        Route::delete('/{id}', [SelectionMenuController::class, 'archive']);
    });

    // 卓マスタ
    Route::prefix('/tables')->group(function () {
        Route::get('/', [TableController::class, 'getAll']);
        Route::post('/', [TableController::class, 'store']);
        Route::get('/{id}', [TableController::class, 'get']);
        Route::put('/{id}', [TableController::class, 'update']);
        Route::delete('/{id}', [TableController::class, 'archive']);
    });

    // 支払い方法マスタ
    Route::prefix('/paymentMethods')->group(function () {
        Route::get('/', [PaymentMethodController::class, 'getAll']);
        Route::post('/', [PaymentMethodController::class, 'store']);
        Route::get('/{id}', [PaymentMethodController::class, 'get']);
        Route::put('/{id}', [PaymentMethodController::class, 'update']);
        Route::delete('/{id}', [PaymentMethodController::class, 'archive']);
    });
});
