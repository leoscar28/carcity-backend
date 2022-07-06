<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class UserRequestRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\UserRequest\UserRequestRepositoryInterface::class,
            \App\Domain\Repositories\UserRequest\UserRequestRepositoryEloquent::class
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
