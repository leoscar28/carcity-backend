<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class NotificationTenantRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\NotificationTenant\NotificationTenantRepositoryInterface::class,
            \App\Domain\Repositories\NotificationTenant\NotificationTenantRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
