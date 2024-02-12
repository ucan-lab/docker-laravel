<?php

namespace App\Services\RegisteredUserService;

use App\Services\{
    RegisteredUserService\RegisteredUserServiceInterface,
    StoreService\StoreServiceInterface,
};
use App\Models\{
    DefaultGroupRole,
    Group,
    User,
    RouteActionTarget,
    SysMenuCategory,
    DefaultStoreRole,
};
use App\Repositories\{
    UserRepository\UserRepositoryInterface,
    GroupRepository\GroupRepositoryInterface,
    RoleRepository\RoleRepositoryInterface,
    MenuCategoryRepository\MenuCategoryRepositoryInterface,
    MenuRepository\MenuRepositoryInterface,
    SetMenuRepository\SetMenuRepositoryInterface,
};

class RegisteredUserService implements RegisteredUserServiceInterface
{

    const DUMMY_STORE = [
        'group_id' => null,
        'name' => 'ダミー店舗',
        'image_path' => 'example.jpg',
        'address' => 'ダミー住所',
        'postal_code' => '1234567',
        'tel_number' => '123-456-789',
        'opening_time' => '19:00',
        'closing_time' => '24:00',
        'working_time_unit_id' => 4,
    ];

    const DUMMY_STORE_DETAIL = [
        'invoice_registration_number' => '123456789',
        'service_rate' => 20,
        'service_rate_digit_id' => 1,
        'service_rate_rounding_method_id' => 1,
        'consumption_tax_rate' => 10,
        'consumption_tax_rate_digit_id' => 1,
        'consumption_tax_rate_rounding_method_id' => 1,
        'consumption_tax_type_id' => 1,
        'user_incentive_digit_id' => 1,
        'user_incentive_rounding_method_id' => 1,
    ];

    const DUMMY_FIRSTSET_MENU_CATEGORY = [
        'sys_menu_category_id' => SysMenuCategory::CATEGORIES['FIRST_SET']['id'],
        'name' => '初回セット',
        'code' => '001'
    ];

    const DUMMY_FIRSTSET_MENU = [
        'menu' => [
            'name' => '初回セット',
            'price' => 3000,
            'insentive_amount' => 1000,
            'code' => '001',
            'display' => true
        ],
        'setMenu' => [
            'minutes' => 50
        ]
    ];

    const DUMMY_EXTENSIONSET_MENU_CATEGORY = [
        'sys_menu_category_id' => SysMenuCategory::CATEGORIES['EXTENSION_SET']['id'],
        'name' => '延長セット',
        'code' => '002'
    ];

    const DUMMY_EXTENSIONSET_MENU = [
        'menu' => [
            'name' => '延長セット',
            'price' => 3000,
            'insentive_amount' => 1000,
            'code' => '002',
            'display' => true
        ],
        'setMenu' => [
            'minutes' => 40
        ]
    ];

    const DUMMY_SELECTION_MENU_CATEGORY = [
        'sys_menu_category_id' => SysMenuCategory::CATEGORIES['SELECTION']['id'],
        'name' => '指名',
        'code' => '003'
    ];

    const DUMMY_DOUHAN_MENU = [
        'name' => '同伴',
        'price' => 3000,
        'insentive_amount' => 1000,
        'code' => '003',
        'display' => true
    ];

    const DUMMY_HONSHIMEI_MENU = [
        'name' => '本指名',
        'price' => 3000,
        'insentive_amount' => 1000,
        'code' => '004',
        'display' => true
    ];

    const DUMMY_JOUNAISHIMEI_MENU = [
        'name' => '場内指名',
        'price' => 2000,
        'insentive_amount' => 500,
        'code' => '005',
        'display' => true
    ];

    const DUMMY_TSUIKASHIMEI_MENU = [
        'name' => '追加指名',
        'price' => 1000,
        'code' => '006',
        'display' => true
    ];

    const DUMMY_BOTTLE_MENU_CATEGORY = [
        'sys_menu_category_id' => SysMenuCategory::CATEGORIES['DRINK_FOOD']['id'],
        'name' => 'ボトル',
        'code' => '004'
    ];

    const DUMMY_BLACKNIKKA_MENU = [
        'name' => 'ブラックニッカ',
        'price' => 5000,
        'insentive_amount' => 1000,
        'code' => '007',
        'display' => true
    ];

    const DUMMY_DRINK_MENU_CATEGORY = [
        'sys_menu_category_id' => SysMenuCategory::CATEGORIES['DRINK_FOOD']['id'],
        'name' => 'ドリンク',
        'code' => '005'
    ];

    const DUMMY_CASTDRINK_MENU = [
        'name' => 'キャストドリンク',
        'price' => 2000,
        'insentive_amount' => 500,
        'code' => '008',
        'display' => true
    ];

    const DUMMY_FOOD_MENU_CATEGORY = [
        'sys_menu_category_id' => SysMenuCategory::CATEGORIES['DRINK_FOOD']['id'],
        'name' => 'フード',
        'code' => '006'
    ];

    const DUMMY_SNACK_MENU = [
        'name' => 'お菓子盛り合わせ',
        'price' => 1000,
        'code' => '009',
        'display' => true
    ];

    const DUMMY_MANAGER_USER = [
        'display_name' => '店長',
    ];

    const DUMMY_STAFF1_USER = [
        'display_name' => 'スタッフ1',
    ];

    const DUMMY_STAFF2_USER = [
        'display_name' => 'スタッフ2',
    ];

    const DUMMY_STAFF3_USER = [
        'display_name' => 'スタッフ3',
    ];

    const DUMMY_CAST1_USER = [
        'display_name' => 'キャスト1',
    ];

    const DUMMY_CAST2_USER = [
        'display_name' => 'キャスト2',
    ];

    const DUMMY_CAST3_USER = [
        'display_name' => 'キャスト3',
    ];

    const DUMMY_CAST4_USER = [
        'display_name' => 'キャスト4',
    ];

    const DUMMY_CAST5_USER = [
        'display_name' => 'キャスト5',
    ];

    public function __construct(
        public readonly UserRepositoryInterface $userRepo,
        public readonly GroupRepositoryInterface $groupRepo,
        public readonly RoleRepositoryInterface $roleRepo,
        public readonly MenuCategoryRepositoryInterface $menuCategoryRepo,
        public readonly MenuRepositoryInterface $menuRepo,
        public readonly SetMenuRepositoryInterface $setMenuRepo,

        public readonly StoreServiceInterface $storeServ,
    ) {
    }

    /**
     * 引数.userを契約者として登録する
     * @param User $user
     * @param string $groupName
     */
    public function registerContractUser(User $user, string $groupName)
    {
        // 契約ユーザー登録
        $this->userRepo->createContractUser($user);

        // グループの作成
        $group = $this->createGroup($groupName);

        // デフォルトグループロールをグループに付与
        $defaultGroupRoles = $this->roleRepo->getAllDefaultGroupRoles();
        $defaultGroupRoleIds = $defaultGroupRoles->pluck("id")->toArray();
        $this->roleRepo->attachRolesToGroup($group, $defaultGroupRoleIds);

        // グループ、ユーザーの紐づけ
        $this->userRepo->attachToGroup($user, $group);

        $this->attachDefaultAdminRoleToUser($user, $group->id);

        /** ダミーデータ登録 */

        // ダミー店舗作成
        $dummyStore = self::DUMMY_STORE;
        $dummyStore['group_id'] = $group->id;
        $store = $this->storeServ->createStore($dummyStore, self::DUMMY_STORE_DETAIL);

        /** メニュー系 */
        // ダミーメニューカテゴリ（初回セット）
        $dummyFirstSetMenuCategoryData = array_merge(self::DUMMY_FIRSTSET_MENU_CATEGORY, ['store_id' => $store->id]);
        $dummyFirstSetMenuCategory = $this->menuCategoryRepo->createMenuCategory($dummyFirstSetMenuCategoryData);
        // 初回セットのセットメニュー作成
        $dummyFirstSetMenuData = array_merge(self::DUMMY_FIRSTSET_MENU['menu'], ['menu_category_id' => $dummyFirstSetMenuCategory->id]);
        $createdFirstSetMenu = $this->menuRepo->createMenu($dummyFirstSetMenuData);
        $this->setMenuRepo->createSetMenu($createdFirstSetMenu, self::DUMMY_FIRSTSET_MENU['setMenu']);

        // ダミーメニューカテゴリ（延長セット）
        $dummyExtensionSetMenuCategoryData = array_merge(self::DUMMY_EXTENSIONSET_MENU_CATEGORY, ['store_id' => $store->id]);
        $dummyExtensionSetMenuCategory = $this->menuCategoryRepo->createMenuCategory($dummyExtensionSetMenuCategoryData);
        // 延長セットのセットメニュー作成
        $dummyExtensionSetMenuData = array_merge(self::DUMMY_EXTENSIONSET_MENU['menu'], ['menu_category_id' => $dummyExtensionSetMenuCategory->id]);
        $createdExtensionSetMenu = $this->menuRepo->createMenu($dummyExtensionSetMenuData);
        $this->setMenuRepo->createSetMenu($createdExtensionSetMenu, self::DUMMY_EXTENSIONSET_MENU['setMenu']);

        // ダミーメニューカテゴリ（指名）
        $dummySelectionMenuCategoryData = array_merge(self::DUMMY_SELECTION_MENU_CATEGORY, ['store_id' => $store->id]);
        $dummySelectionMenuCategory = $this->menuCategoryRepo->createMenuCategory($dummySelectionMenuCategoryData);
        // 同伴のセットメニュー作成
        $dummyDouhanMenuData = array_merge(self::DUMMY_DOUHAN_MENU, ['menu_category_id' => $dummySelectionMenuCategory->id]);
        $this->menuRepo->createMenu($dummyDouhanMenuData);
        // 本指名
        $dummyHonshimeiMenuData = array_merge(self::DUMMY_HONSHIMEI_MENU, ['menu_category_id' => $dummySelectionMenuCategory->id]);
        $this->menuRepo->createMenu($dummyHonshimeiMenuData);
        // 場内指名
        $dummyJounaiMenuData = array_merge(self::DUMMY_JOUNAISHIMEI_MENU, ['menu_category_id' => $dummySelectionMenuCategory->id]);
        $this->menuRepo->createMenu($dummyJounaiMenuData);
        // 追加指名
        $dummyTsuikaMenuData = array_merge(self::DUMMY_TSUIKASHIMEI_MENU, ['menu_category_id' => $dummySelectionMenuCategory->id]);
        $this->menuRepo->createMenu($dummyTsuikaMenuData);

        // ダミーメニューカテゴリ（ボトル）
        $dummyBottleMenuCategoryData = array_merge(self::DUMMY_BOTTLE_MENU_CATEGORY, ['store_id' => $store->id]);
        $dummyBottleMenuCategory = $this->menuCategoryRepo->createMenuCategory($dummyBottleMenuCategoryData);
        // ブラックニッカ
        $dummyBlacknikkaMenuData = array_merge(self::DUMMY_BLACKNIKKA_MENU, ['menu_category_id' => $dummyBottleMenuCategory->id]);
        $this->menuRepo->createMenu($dummyBlacknikkaMenuData);

        // ダミーメニューカテゴリ（ドリンク）
        $dummyDrinkMenuCategoryData = array_merge(self::DUMMY_DRINK_MENU_CATEGORY, ['store_id' => $store->id]);
        $dummyDrinkMenuCategory = $this->menuCategoryRepo->createMenuCategory($dummyDrinkMenuCategoryData);
        // キャストドリンク
        $dummyCastDrinkMenuData = array_merge(self::DUMMY_CASTDRINK_MENU, ['menu_category_id' => $dummyDrinkMenuCategory->id]);
        $this->menuRepo->createMenu($dummyCastDrinkMenuData);

        // ダミーメニューカテゴリ（フード）
        $dummyFoodMenuCategoryData = array_merge(self::DUMMY_FOOD_MENU_CATEGORY, ['store_id' => $store->id]);
        $dummyFoodMenuCategory = $this->menuCategoryRepo->createMenuCategory($dummyFoodMenuCategoryData);
        // お菓子盛り合わせ
        $dummySnackMenuData = array_merge(self::DUMMY_SNACK_MENU, ['menu_category_id' => $dummyFoodMenuCategory->id]);
        $this->menuRepo->createMenu($dummySnackMenuData);

        /** ダミーユーザー作成 */
        // グループロール取得
        $groupRoles = $this->roleRepo->getAllDefaultGroupRolesByGroupId($group->id);
        // 一般のグループロールを取得
        $generalGroupRole = $groupRoles->first(function ($groupRole) {
            return $groupRole->role->name === DefaultGroupRole::DEFAULT_GROUP_GENERAL['name'];
        });

        // ストアロール取得
        $storeRoles = $this->roleRepo->getAllDefaultStoreRolesByStoreId($store->id);
        // マネージャーのストアロールを取得
        $managerStoreRole = $storeRoles->first(function ($storeRole) {
            return $storeRole->role->name === DefaultStoreRole::DEFAULT_STORE_MANAGER['name'];
        });
        // スタッフのストアロールを取得
        $staffStoreRole = $storeRoles->first(function ($storeRole) {
            return $storeRole->role->name === DefaultStoreRole::DEFAULT_STORE_STAFF['name'];
        });
        // キャストのストアロールを取得
        $castStoreRole = $storeRoles->first(function ($storeRole) {
            return $storeRole->role->name === DefaultStoreRole::DEFAULT_STORE_CAST['name'];
        });

        // 店長
        $managerUser = $this->userRepo->createGeneralUser(self::DUMMY_MANAGER_USER, ['can_login' => \App\Models\GeneralUser::LOGIN_DENY['id']]);
        // ユーザーをグループに所属させる
        $this->userRepo->attachToGroup($managerUser, $group);
        // ユーザーとグループロールの紐付け
        $this->roleRepo->attachGroupRolesToUser($managerUser, [$generalGroupRole->id]);
        // ユーザーを店舗に所属させる
        $this->userRepo->attachToStores($managerUser, [$store->id]);
        // ユーザーとストアロールの紐付け
        $this->roleRepo->attachStoreRolesToUser($managerUser, [$managerStoreRole->id]);

        // スタッフ1
        $staff1User = $this->userRepo->createGeneralUser(self::DUMMY_STAFF1_USER, ['can_login' => \App\Models\GeneralUser::LOGIN_DENY['id']]);
        // ユーザーをグループに所属させる
        $this->userRepo->attachToGroup($staff1User, $group);
        // ユーザーとグループロールの紐付け
        $this->roleRepo->attachGroupRolesToUser($staff1User, [$generalGroupRole->id]);
        // ユーザーを店舗に所属させる
        $this->userRepo->attachToStores($staff1User, [$store->id]);
        // ユーザーとストアロールの紐付け
        $this->roleRepo->attachStoreRolesToUser($staff1User, [$staffStoreRole->id]);

        // スタッフ2
        $staff2User = $this->userRepo->createGeneralUser(self::DUMMY_STAFF2_USER, ['can_login' => \App\Models\GeneralUser::LOGIN_DENY['id']]);
        // ユーザーをグループに所属させる
        $this->userRepo->attachToGroup($staff2User, $group);
        // ユーザーとグループロールの紐付け
        $this->roleRepo->attachGroupRolesToUser($staff2User, [$generalGroupRole->id]);
        // ユーザーを店舗に所属させる
        $this->userRepo->attachToStores($staff2User, [$store->id]);
        // ユーザーとストアロールの紐付け
        $this->roleRepo->attachStoreRolesToUser($staff2User, [$staffStoreRole->id]);

        // スタッフ3
        $staff3User = $this->userRepo->createGeneralUser(self::DUMMY_STAFF3_USER, ['can_login' => \App\Models\GeneralUser::LOGIN_DENY['id']]);
        // ユーザーをグループに所属させる
        $this->userRepo->attachToGroup($staff3User, $group);
        // ユーザーとグループロールの紐付け
        $this->roleRepo->attachGroupRolesToUser($staff3User, [$generalGroupRole->id]);
        // ユーザーを店舗に所属させる
        $this->userRepo->attachToStores($staff3User, [$store->id]);
        // ユーザーとストアロールの紐付け
        $this->roleRepo->attachStoreRolesToUser($staff3User, [$staffStoreRole->id]);

        // キャスト1
        $cast1User = $this->userRepo->createGeneralUser(self::DUMMY_CAST1_USER, ['can_login' => \App\Models\GeneralUser::LOGIN_DENY['id']]);
        // ユーザーをグループに所属させる
        $this->userRepo->attachToGroup($cast1User, $group);
        // ユーザーとグループロールの紐付け
        $this->roleRepo->attachGroupRolesToUser($cast1User, [$generalGroupRole->id]);
        // ユーザーを店舗に所属させる
        $this->userRepo->attachToStores($cast1User, [$store->id]);
        // ユーザーとストアロールの紐付け
        $this->roleRepo->attachStoreRolesToUser($cast1User, [$castStoreRole->id]);

        // キャスト2
        $cast2User = $this->userRepo->createGeneralUser(self::DUMMY_CAST2_USER, ['can_login' => \App\Models\GeneralUser::LOGIN_DENY['id']]);
        // ユーザーをグループに所属させる
        $this->userRepo->attachToGroup($cast2User, $group);
        // ユーザーとグループロールの紐付け
        $this->roleRepo->attachGroupRolesToUser($cast2User, [$generalGroupRole->id]);
        // ユーザーを店舗に所属させる
        $this->userRepo->attachToStores($cast2User, [$store->id]);
        // ユーザーとストアロールの紐付け
        $this->roleRepo->attachStoreRolesToUser($cast2User, [$castStoreRole->id]);

        // キャスト3
        $cast3User = $this->userRepo->createGeneralUser(self::DUMMY_CAST3_USER, ['can_login' => \App\Models\GeneralUser::LOGIN_DENY['id']]);
        // ユーザーをグループに所属させる
        $this->userRepo->attachToGroup($cast3User, $group);
        // ユーザーとグループロールの紐付け
        $this->roleRepo->attachGroupRolesToUser($cast3User, [$generalGroupRole->id]);
        // ユーザーを店舗に所属させる
        $this->userRepo->attachToStores($cast3User, [$store->id]);
        // ユーザーとストアロールの紐付け
        $this->roleRepo->attachStoreRolesToUser($cast3User, [$castStoreRole->id]);

        // キャスト4
        $cast4User = $this->userRepo->createGeneralUser(self::DUMMY_CAST4_USER, ['can_login' => \App\Models\GeneralUser::LOGIN_DENY['id']]);
        // ユーザーをグループに所属させる
        $this->userRepo->attachToGroup($cast4User, $group);
        // ユーザーとグループロールの紐付け
        $this->roleRepo->attachGroupRolesToUser($cast4User, [$generalGroupRole->id]);
        // ユーザーを店舗に所属させる
        $this->userRepo->attachToStores($cast4User, [$store->id]);
        // ユーザーとストアロールの紐付け
        $this->roleRepo->attachStoreRolesToUser($cast4User, [$castStoreRole->id]);

        // キャスト5
        $cast5User = $this->userRepo->createGeneralUser(self::DUMMY_CAST5_USER, ['can_login' => \App\Models\GeneralUser::LOGIN_DENY['id']]);
        // ユーザーをグループに所属させる
        $this->userRepo->attachToGroup($cast5User, $group);
        // ユーザーとグループロールの紐付け
        $this->roleRepo->attachGroupRolesToUser($cast5User, [$generalGroupRole->id]);
        // ユーザーを店舗に所属させる
        $this->userRepo->attachToStores($cast5User, [$store->id]);
        // ユーザーとストアロールの紐付け
        $this->roleRepo->attachStoreRolesToUser($cast5User, [$castStoreRole->id]);
    }

    /**
     * グループを作成する
     * @param string $groupName グループ名
     * @return Group
     */
    private function createGroup(string $groupName): Group
    {
        // グループを作成
        $group = $this->groupRepo->createGroup([
            'name' => $groupName,
        ]);

        return $group;
    }

    /**
     * ユーザーに管理者権限を付与する
     * @param Group $group
     * @param User $user
     * @param int $groupId
     * @return void
     */
    private function attachDefaultAdminRoleToUser(User $user, int $groupId)
    {
        $adminRole = $this->roleRepo->getDefaultAdminGroupRole($groupId);

        // ユーザーに管理者権限を付与
        $this->roleRepo->attachGroupRolesToUser($user, [$adminRole->id]);
    }
}
