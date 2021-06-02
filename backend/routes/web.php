<?php

use Illuminate\Support\Facades\Route;
// コントローラー増えた際に毎回追加?
use App\Http\Controllers\HelloController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// helloworld呼び出し
Route::get('/hello', [HelloController::class, 'index']);