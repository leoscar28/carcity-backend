<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class UserBannerRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\UserBanner\UserBannerRepositoryInterface::class,
            \App\Domain\Repositories\UserBanner\UserBannerRepositoryEloquent::class
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
