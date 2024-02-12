<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteAction extends Model
{
    use HasFactory;

    const ROUTE_ACTIONS = [
        // Store
        'STORE_CREATE' => ['id' => 1, 'name' => 'StoreController@create'],
        'STORE_STORE' => ['id' => 2, 'name' => 'StoreController@store'],
        'STORE_SHOW' => ['id' => 3, 'name' => 'StoreController@show'],
        'STORE_EDIT' => ['id' => 4, 'name' => 'StoreController@edit'],
        'STORE_UPDATE' => ['id' => 5, 'name' => 'StoreController@update'],

        // User
        'USER_INDEX' => ['id' => 6, 'name' => 'UserController@index'],
        'USER_CREATE' => ['id' => 7, 'name' => 'UserController@create'],
        'USER_STORE' => ['id' => 8, 'name' => 'UserController@store'],
        'USER_EDIT' => ['id' => 9, 'name' => 'UserController@edit'],
        'USER_UPDATE' => ['id' => 10, 'name' => 'UserController@update'],
        'USER_ARCHIVE' => ['id' => 11, 'name' => 'UserController@archive'],

        // MenuCategory
        'MENUCATEGORY_INDEX' => ['id' => 12, 'name' => 'MenuCategoryController@index'],
        'MENUCATEGORY_CREATE' => ['id' => 13, 'name' => 'MenuCategoryController@create'],
        'MENUCATEGORY_STORE' => ['id' => 14, 'name' => 'MenuCategoryController@store'],
        'MENUCATEGORY_EDIT' => ['id' => 15, 'name' => 'MenuCategoryController@edit'],
        'MENUCATEGORY_UPDATE' => ['id' => 16, 'name' => 'MenuCategoryController@update'],
        'MENUCATEGORY_ARCHIVE' => ['id' => 17, 'name' => 'MenuCategoryController@archive'],

        // Table
        'TABLE_INDEX' => ['id' => 18, 'name' => 'TableController@index'],
        'TABLE_CREATE' => ['id' => 19, 'name' => 'TableController@create'],
        'TABLE_STORE' => ['id' => 20, 'name' => 'TableController@store'],
        'TABLE_EDIT' => ['id' => 21, 'name' => 'TableController@edit'],
        'TABLE_UPDATE' => ['id' => 22, 'name' => 'TableController@update'],
        'TABLE_ARCHIVE' => ['id' => 23, 'name' => 'TableController@archive'],

        // Menu
        'MENU_INDEX' => ['id' => 24, 'name' => 'MenuController@index'],
        'MENU_CREATE' => ['id' => 25, 'name' => 'MenuController@create'],
        'MENU_STORE' => ['id' => 26, 'name' => 'MenuController@store'],
        'MENU_EDIT' => ['id' => 27, 'name' => 'MenuController@edit'],
        'MENU_UPDATE' => ['id' => 28, 'name' => 'MenuController@update'],
        'MENU_ARCHIVE' => ['id' => 29, 'name' => 'MenuController@archive'],

        // PaymentMethod
        'PAYMENTMETHOD_INDEX' => ['id' => 30, 'name' => 'PaymentMethodController@index'],
        'PAYMENTMETHOD_CREATE' => ['id' => 31, 'name' => 'PaymentMethodController@create'],
        'PAYMENTMETHOD_STORE' => ['id' => 32, 'name' => 'PaymentMethodController@store'],
        'PAYMENTMETHOD_EDIT' => ['id' => 33, 'name' => 'PaymentMethodController@edit'],
        'PAYMENTMETHOD_UPDATE' => ['id' => 34, 'name' => 'PaymentMethodController@update'],
        'PAYMENTMETHOD_ARCHIVE' => ['id' => 35, 'name' => 'PaymentMethodController@archive'],

        // BusinessDate
        'OPENINGPREPARATION_CREATE' => ['id' => 36, 'name' => 'OpeningPreparationController@create'],
        'OPENINGPREPARATION_STORE' => ['id' => 37, 'name' => 'OpeningPreparationController@store'],

        // Attendance
        'ATTENDANCE_INDEX' => ['id' => 38, 'name' => 'AttendanceController@index'],
        'ATTENDANCE_BULKEDIT' => ['id' => 39, 'name' => 'AttendanceController@bulkEdit'],
        'ATTENDANCE_BULKUPDATE' => ['id' => 40, 'name' => 'AttendanceController@bulkUpdate'],

        // ExtensionSet
        'EXTENSIONSET_STORE' => ['id' => 41, 'name' => 'ExtensionSetController@store'],
    ];

    public static function getRouteActionById($id) {
        foreach (self::ROUTE_ACTIONS as $routeAction) {
            if ($routeAction['id'] === $id) {
                return $routeAction;
            }
        }
        return null;
    }
}
