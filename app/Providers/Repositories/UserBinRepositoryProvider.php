<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class UserBinRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\UserBin\UserBinRepositoryInterface::class,
            \App\Domain\Repositories\UserBin\UserBinRepositoryEloquent::class
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
