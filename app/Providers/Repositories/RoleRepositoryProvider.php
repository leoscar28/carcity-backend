<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class RoleRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\Role\RoleRepositoryInterface::class,
            \App\Domain\Repositories\Role\RoleRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
