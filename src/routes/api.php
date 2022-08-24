<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/profiles', function () {
    return [
        'nickname' => "taro",
        'gender' => 0,
        'birthday' => 19990101,
        'blood_type' => "A",
        'residence' => "神奈川",
        'height' => 170,
        'weight' => 60,
        'character' => 1,
        'favorite' => 'カレー',
    ];
});

Route::get('/favorites', function () {
    return [
        'character' => 1,
        'height' => 170,
        'weight' => 60,
        'favorites' => "石原さとみ",
        'messages' => "こんにちは",
    ];
});

Route::post('/profiles', function () {
    return 'ok';
});



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

