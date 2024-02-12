<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultGroupRole extends Model
{
    use HasFactory;

     /**
     * デフォルトグループロール
     */
    const DEFAULT_GROUP_ROLES = [
        self::DEFAULT_GROUP_ADMIN,
        self::DEFAULT_GROUP_GENERAL,
    ];

    const DEFAULT_GROUP_ADMIN = [
        'name' => '管理者',
        'routeActionTargets' => [
            // store
            RouteActionTarget::ROUTE_ACTION_TARGETS['STORE_CREATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['STORE_STORE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['STORE_SHOW_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['STORE_SHOW_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['STORE_EDIT_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['STORE_EDIT_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['STORE_UPDATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['STORE_UPDATE_TARGET_GROUP']['id'],

            // user
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_INDEX_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_INDEX_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_CREATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_CREATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_STORE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_STORE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_EDIT_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_EDIT_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_UPDATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_UPDATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_ARCHIVE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['USER_ARCHIVE_TARGET_STORE']['id'],

            // table
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_INDEX_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_INDEX_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_CREATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_CREATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_STORE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_STORE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_EDIT_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_EDIT_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_UPDATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_UPDATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_ARCHIVE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['TABLE_ARCHIVE_TARGET_STORE']['id'],

            // MenuCategory
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_INDEX_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_INDEX_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_CREATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_CREATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_STORE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_STORE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_EDIT_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_EDIT_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_UPDATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_UPDATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_ARCHIVE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENUCATEGORY_ARCHIVE_TARGET_STORE']['id'],

            // Menu
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_INDEX_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_INDEX_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_CREATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_CREATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_STORE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_STORE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_EDIT_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_EDIT_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_UPDATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_UPDATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_ARCHIVE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['MENU_ARCHIVE_TARGET_STORE']['id'],

            // PaymentMethod
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_INDEX_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_INDEX_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_CREATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_CREATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_STORE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_STORE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_EDIT_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_EDIT_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_UPDATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_UPDATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_ARCHIVE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['PAYMENTMETHOD_ARCHIVE_TARGET_STORE']['id'],

            // BusinessDate
            RouteActionTarget::ROUTE_ACTION_TARGETS['OPENINGPREPARATION_CREATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['OPENINGPREPARATION_CREATE_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['OPENINGPREPARATION_STORE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['OPENINGPREPARATION_STORE_TARGET_STORE']['id'],

            // Attendance
            RouteActionTarget::ROUTE_ACTION_TARGETS['ATTENDANCE_INDEX_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['ATTENDANCE_INDEX_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['ATTENDANCE_BULKEDIT_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['ATTENDANCE_BULKEDIT_TARGET_STORE']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['ATTENDANCE_BULKUPDATE_TARGET_GROUP']['id'],
            RouteActionTarget::ROUTE_ACTION_TARGETS['ATTENDANCE_BULKUPDATE_TARGET_STORE']['id'],

            // ExtensionSet
            RouteActionTarget::ROUTE_ACTION_TARGETS['EXTENSIONSET_STORE_TARGET_GROUP']['id'],

            // hall
        ]
    ];

    const DEFAULT_GROUP_GENERAL =  [
        'name' => '一般',
        'routeActionTargets' => []
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
