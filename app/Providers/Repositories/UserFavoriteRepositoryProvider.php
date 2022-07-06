<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class UserFavoriteRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\UserFavorite\UserFavoriteRepositoryInterface::class,
            \App\Domain\Repositories\UserFavorite\UserFavoriteRepositoryEloquent::class
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
