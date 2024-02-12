<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\UserRepository\{
    UserRepositoryInterface,
    UserRepository
};
use App\Repositories\GroupRepository\{
    GroupRepositoryInterface,
    GroupRepository
};
use App\Repositories\StoreRepository\{
    StoreRepositoryInterface,
    StoreRepository
};
use App\Repositories\StoreDetailRepository\{
    StoreDetailRepositoryInterface,
    StoreDetailRepository
};
use App\Repositories\RoleRepository\{
    RoleRepositoryInterface,
    RoleRepository
};
use App\Repositories\TableRepository\{
    TableRepositoryInterface,
    TableRepository
};
use App\Repositories\PaymentMethodRepository\{
    PaymentMethodRepositoryInterface,
    PaymentMethodRepository
};
use App\Repositories\SysPaymentMethodCategoryRepository\{
    SysPaymentMethodCategoryRepositoryInterface,
    SysPaymentMethodCategoryRepository
};
use App\Repositories\MenuCategoryRepository\{
    MenuCategoryRepositoryInterface,
    MenuCategoryRepository
};
use App\Repositories\MenuRepository\{
    MenuRepositoryInterface,
    MenuRepository
};
use App\Repositories\SetMenuRepository\{
    SetMenuRepositoryInterface,
    SetMenuRepository
};
use App\Repositories\BusinessDateRepository\{
    BusinessDateRepositoryInterface,
    BusinessDateRepository
};
use App\Repositories\CashRegisterRepository\{
    CashRegisterRepositoryInterface,
    CashRegisterRepository
};
use App\Repositories\AttendanceRepository\{
    AttendanceRepositoryInterface,
    AttendanceRepository
};
use App\Repositories\BillRepository\{
    BillRepositoryInterface,
    BillRepository
};
use App\Repositories\ItemizedOrderRepository\{
    ItemizedOrderRepositoryInterface,
    ItemizedOrderRepository
};
use App\Repositories\OrderRepository\{
    OrderRepositoryInterface,
    OrderRepository
};
use App\Repositories\NumberOfCustomerRepository\{
    NumberOfCustomerRepositoryInterface,
    NumberOfCustomerRepository
};
use App\Repositories\UserIncentiveRepository\{
    UserIncentiveRepositoryInterface,
    UserIncentiveRepository
};
use App\Repositories\SelectionOrderRepository\{
    SelectionOrderRepositoryInterface,
    SelectionOrderRepository
};
use App\Repositories\ItemizedSetOrderRepository\{
    ItemizedSetOrderRepositoryInterface,
    ItemizedSetOrderRepository
};
use App\Repositories\ModifiedOrderRepository\{
    ModifiedOrderRepositoryInterface,
    ModifiedOrderRepository
};
use App\Repositories\BillPaymentRepository\{
    BillPaymentRepositoryInterface,
    BillPaymentRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            BillPaymentRepositoryInterface::class,
            BillPaymentRepository::class
        );

        $this->app->bind(
            ModifiedOrderRepositoryInterface::class,
            ModifiedOrderRepository::class
        );

        $this->app->bind(
            ItemizedSetOrderRepositoryInterface::class,
            ItemizedSetOrderRepository::class
        );

        $this->app->bind(
            SelectionOrderRepositoryInterface::class,
            SelectionOrderRepository::class
        );

        $this->app->bind(
            UserIncentiveRepositoryInterface::class,
            UserIncentiveRepository::class
        );

        $this->app->bind(
            NumberOfCustomerRepositoryInterface::class,
            NumberOfCustomerRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            GroupRepositoryInterface::class,
            GroupRepository::class
        );

        $this->app->bind(
            StoreRepositoryInterface::class,
            StoreRepository::class
        );

        $this->app->bind(
            StoreDetailRepositoryInterface::class,
            StoreDetailRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $this->app->bind(
            TableRepositoryInterface::class,
            TableRepository::class
        );

        $this->app->bind(
            PaymentMethodRepositoryInterface::class,
            PaymentMethodRepository::class
        );

        $this->app->bind(
            SysPaymentMethodCategoryRepositoryInterface::class,
            SysPaymentMethodCategoryRepository::class
        );

        $this->app->bind(
            MenuCategoryRepositoryInterface::class,
            MenuCategoryRepository::class
        );

        $this->app->bind(
            MenuRepositoryInterface::class,
            MenuRepository::class
        );

        $this->app->bind(
            SetMenuRepositoryInterface::class,
            SetMenuRepository::class
        );
        $this->app->bind(
            BusinessDateRepositoryInterface::class,
            BusinessDateRepository::class
        );
        $this->app->bind(
            CashRegisterRepositoryInterface::class,
            CashRegisterRepository::class
        );

        $this->app->bind(
            AttendanceRepositoryInterface::class,
            AttendanceRepository::class
        );

        $this->app->bind(
            BillRepositoryInterface::class,
            BillRepository::class
        );

        $this->app->bind(
            ItemizedOrderRepositoryInterface::class,
            ItemizedOrderRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
    }
}
