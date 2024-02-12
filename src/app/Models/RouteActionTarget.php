<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RouteActionTarget extends Model
{
    use HasFactory;
    protected $table = 'route_action_target';

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    const ROUTE_ACTION_TARGETS = [
        // Store
        'STORE_CREATE_TARGET_GROUP' => ['id' => 1, 'route_action_id' => RouteAction::ROUTE_ACTIONS['STORE_CREATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'STORE_STORE_TARGET_GROUP' => ['id' => 2, 'route_action_id' => RouteAction::ROUTE_ACTIONS['STORE_STORE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'STORE_SHOW_TARGET_STORE' => ['id' => 3, 'route_action_id' => RouteAction::ROUTE_ACTIONS['STORE_SHOW']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'STORE_SHOW_TARGET_GROUP' => ['id' => 4, 'route_action_id' => RouteAction::ROUTE_ACTIONS['STORE_SHOW']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'STORE_EDIT_TARGET_STORE' => ['id' => 5, 'route_action_id' => RouteAction::ROUTE_ACTIONS['STORE_EDIT']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'STORE_EDIT_TARGET_GROUP' => ['id' => 6, 'route_action_id' => RouteAction::ROUTE_ACTIONS['STORE_EDIT']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'STORE_UPDATE_TARGET_STORE' => ['id' => 7, 'route_action_id' => RouteAction::ROUTE_ACTIONS['STORE_UPDATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'STORE_UPDATE_TARGET_GROUP' => ['id' => 8, 'route_action_id' => RouteAction::ROUTE_ACTIONS['STORE_UPDATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],

        // User
        'USER_INDEX_TARGET_STORE' => ['id' => 9, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_INDEX']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'USER_INDEX_TARGET_GROUP' => ['id' => 10, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_INDEX']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'USER_CREATE_TARGET_STORE' => ['id' => 11, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_CREATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'USER_CREATE_TARGET_GROUP' => ['id' => 12, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_CREATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'USER_STORE_TARGET_STORE' => ['id' => 13, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_STORE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'USER_STORE_TARGET_GROUP' => ['id' => 14, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_STORE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'USER_EDIT_TARGET_STORE' => ['id' => 15, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_EDIT']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'USER_EDIT_TARGET_GROUP' => ['id' => 16, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_EDIT']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'USER_UPDATE_TARGET_STORE' => ['id' => 17, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_UPDATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'USER_UPDATE_TARGET_GROUP' => ['id' => 18, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_UPDATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'USER_ARCHIVE_TARGET_STORE' => ['id' => 19, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_ARCHIVE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'USER_ARCHIVE_TARGET_GROUP' => ['id' => 20, 'route_action_id' => RouteAction::ROUTE_ACTIONS['USER_ARCHIVE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],

        // MenuCategory
        'MENUCATEGORY_INDEX_TARGET_GROUP' => ['id' => 21, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_INDEX']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENUCATEGORY_INDEX_TARGET_STORE' => ['id' => 22, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_INDEX']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENUCATEGORY_CREATE_TARGET_GROUP' => ['id' => 23, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_CREATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENUCATEGORY_CREATE_TARGET_STORE' => ['id' => 24, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_CREATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENUCATEGORY_STORE_TARGET_GROUP' => ['id' => 25, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_STORE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENUCATEGORY_STORE_TARGET_STORE' => ['id' => 26, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_STORE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENUCATEGORY_EDIT_TARGET_GROUP' => ['id' => 27, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_EDIT']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENUCATEGORY_EDIT_TARGET_STORE' => ['id' => 28, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_EDIT']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENUCATEGORY_UPDATE_TARGET_GROUP' => ['id' => 29, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_UPDATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENUCATEGORY_UPDATE_TARGET_STORE' => ['id' => 30, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_UPDATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENUCATEGORY_ARCHIVE_TARGET_GROUP' => ['id' => 31, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_ARCHIVE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENUCATEGORY_ARCHIVE_TARGET_STORE' => ['id' => 32, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENUCATEGORY_ARCHIVE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],

        // Table
        'TABLE_INDEX_TARGET_GROUP' => ['id' => 33, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_INDEX']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'TABLE_INDEX_TARGET_STORE' => ['id' => 34, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_INDEX']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'TABLE_CREATE_TARGET_GROUP' => ['id' => 35, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_CREATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'TABLE_CREATE_TARGET_STORE' => ['id' => 36, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_CREATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'TABLE_STORE_TARGET_GROUP' => ['id' => 37, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_STORE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'TABLE_STORE_TARGET_STORE' => ['id' => 38, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_STORE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'TABLE_EDIT_TARGET_GROUP' => ['id' => 39, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_EDIT']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'TABLE_EDIT_TARGET_STORE' => ['id' => 40, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_EDIT']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'TABLE_UPDATE_TARGET_GROUP' => ['id' => 41, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_UPDATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'TABLE_UPDATE_TARGET_STORE' => ['id' => 42, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_UPDATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'TABLE_ARCHIVE_TARGET_GROUP' => ['id' => 43, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_ARCHIVE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'TABLE_ARCHIVE_TARGET_STORE' => ['id' => 44, 'route_action_id' => RouteAction::ROUTE_ACTIONS['TABLE_ARCHIVE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],

        // Menu
        'MENU_INDEX_TARGET_GROUP' => ['id' => 45, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_INDEX']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENU_INDEX_TARGET_STORE' => ['id' => 46, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_INDEX']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENU_CREATE_TARGET_GROUP' => ['id' => 47, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_CREATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENU_CREATE_TARGET_STORE' => ['id' => 48, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_CREATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENU_STORE_TARGET_GROUP' => ['id' => 49, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_STORE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENU_STORE_TARGET_STORE' => ['id' => 50, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_STORE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENU_EDIT_TARGET_GROUP' => ['id' => 51, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_EDIT']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENU_EDIT_TARGET_STORE' => ['id' => 52, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_EDIT']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENU_UPDATE_TARGET_GROUP' => ['id' => 53, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_UPDATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENU_UPDATE_TARGET_STORE' => ['id' => 54, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_UPDATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'MENU_ARCHIVE_TARGET_GROUP' => ['id' => 55, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_ARCHIVE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'MENU_ARCHIVE_TARGET_STORE' => ['id' => 56, 'route_action_id' => RouteAction::ROUTE_ACTIONS['MENU_ARCHIVE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],

        // PaymentMethod
        'PAYMENTMETHOD_INDEX_TARGET_GROUP' => ['id' => 57, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_INDEX']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'PAYMENTMETHOD_INDEX_TARGET_STORE' => ['id' => 58, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_INDEX']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'PAYMENTMETHOD_CREATE_TARGET_GROUP' => ['id' => 59, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_CREATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'PAYMENTMETHOD_CREATE_TARGET_STORE' => ['id' => 60, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_CREATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'PAYMENTMETHOD_STORE_TARGET_GROUP' => ['id' => 61, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_STORE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'PAYMENTMETHOD_STORE_TARGET_STORE' => ['id' => 62, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_STORE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'PAYMENTMETHOD_EDIT_TARGET_GROUP' => ['id' => 63, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_EDIT']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'PAYMENTMETHOD_EDIT_TARGET_STORE' => ['id' => 64, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_EDIT']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'PAYMENTMETHOD_UPDATE_TARGET_GROUP' => ['id' => 65, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_UPDATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'PAYMENTMETHOD_UPDATE_TARGET_STORE' => ['id' => 66, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_UPDATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'PAYMENTMETHOD_ARCHIVE_TARGET_GROUP' => ['id' => 67, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_ARCHIVE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'PAYMENTMETHOD_ARCHIVE_TARGET_STORE' => ['id' => 68, 'route_action_id' => RouteAction::ROUTE_ACTIONS['PAYMENTMETHOD_ARCHIVE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],

        // BusinessDate
        'OPENINGPREPARATION_CREATE_TARGET_GROUP' => ['id' => 69, 'route_action_id' => RouteAction::ROUTE_ACTIONS['OPENINGPREPARATION_CREATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'OPENINGPREPARATION_CREATE_TARGET_STORE' => ['id' => 70, 'route_action_id' => RouteAction::ROUTE_ACTIONS['OPENINGPREPARATION_CREATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'OPENINGPREPARATION_STORE_TARGET_GROUP' => ['id' => 71, 'route_action_id' => RouteAction::ROUTE_ACTIONS['OPENINGPREPARATION_STORE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'OPENINGPREPARATION_STORE_TARGET_STORE' => ['id' => 72, 'route_action_id' => RouteAction::ROUTE_ACTIONS['OPENINGPREPARATION_STORE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],

        // Attendance
        'ATTENDANCE_INDEX_TARGET_GROUP' => ['id' => 73, 'route_action_id' => RouteAction::ROUTE_ACTIONS['ATTENDANCE_INDEX']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'ATTENDANCE_INDEX_TARGET_STORE' => ['id' => 74, 'route_action_id' => RouteAction::ROUTE_ACTIONS['ATTENDANCE_INDEX']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'ATTENDANCE_BULKEDIT_TARGET_GROUP' => ['id' => 75, 'route_action_id' => RouteAction::ROUTE_ACTIONS['ATTENDANCE_BULKEDIT']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'ATTENDANCE_BULKEDIT_TARGET_STORE' => ['id' => 76, 'route_action_id' => RouteAction::ROUTE_ACTIONS['ATTENDANCE_BULKEDIT']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
        'ATTENDANCE_BULKUPDATE_TARGET_GROUP' => ['id' => 77, 'route_action_id' => RouteAction::ROUTE_ACTIONS['ATTENDANCE_BULKUPDATE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'ATTENDANCE_BULKUPDATE_TARGET_STORE' => ['id' => 78, 'route_action_id' => RouteAction::ROUTE_ACTIONS['ATTENDANCE_BULKUPDATE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],

        // ExtensionSet
        'EXTENSIONSET_STORE_TARGET_GROUP' => ['id' => 79, 'route_action_id' => RouteAction::ROUTE_ACTIONS['EXTENSIONSET_STORE']['id'], 'target_id' => Target::TARGETS['GROUP']['id']],
        'EXTENSIONSET_STORE_TARGET_STORE' => ['id' => 80, 'route_action_id' => RouteAction::ROUTE_ACTIONS['EXTENSIONSET_STORE']['id'], 'target_id' => Target::TARGETS['STORE']['id']],
    ];

    public static function getRouteActionTargetById($id) {
        foreach (self::ROUTE_ACTION_TARGETS as $routeActionTarget) {
            if ($routeActionTarget['id'] === $id) {
                return $routeActionTarget;
            }
        }
        return null;
    }

}
