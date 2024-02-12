<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\{
    RegisteredUserService\RegisteredUserServiceInterface,
    RegisteredUserService\RegisteredUserService,
    StoreService\StoreServiceInterface,
    StoreService\StoreService,
    RoleService\RoleServiceInterface,
    RoleService\RoleService,
    AttendanceService\AttendanceServiceInterface,
    AttendanceService\AttendanceService,
    BillService\BillServiceInterface,
    BillService\BillService,
    OrderService\OrderServiceInterface,
    OrderService\OrderService,
    StoreSalesService\StoreSalesServiceInterface,
    StoreSalesService\StoreSalesService,
};

class ServiceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            StoreSalesServiceInterface::class,
            StoreSalesService::class
        );

        $this->app->bind(
            OrderServiceInterface::class,
            OrderService::class
        );

        $this->app->bind(
            BillServiceInterface::class,
            BillService::class
        );

        $this->app->bind(
            RegisteredUserServiceInterface::class,
            RegisteredUserService::class
        );

        $this->app->bind(
            StoreServiceInterface::class,
            StoreService::class
        );

        $this->app->bind(
            RoleServiceInterface::class,
            RoleService::class
        );

        $this->app->bind(
            AttendanceServiceInterface::class,
            AttendanceService::class
        );
    }
}
