<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\{
    Store,
    User,
    MenuCategory,
    Menu,
    Table,
    PaymentMethod,
    Attendance,
    Bill,
    ItemizedOrder
};
use App\Policies\{
    StorePolicy,
    UserPolicy,
    MenuCategoryPolicy,
    MenuPolicy,
    TablePolicy,
    PaymentMethodPolicy,
    AttendancePolicy,
    BillPolicy,
    ItemizedOrderPolicy
};

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Store::class => StorePolicy::class,
        User::class => UserPolicy::class,
        Table::class => TablePolicy::class,
        MenuCategory::class => MenuCategoryPolicy::class,
        Menu::class => MenuPolicy::class,
        PaymentMethod::class => PaymentMethodPolicy::class,
        Attendance::class => AttendancePolicy::class,
        ItemizedOrder::class => ItemizedOrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        //
    }
}
