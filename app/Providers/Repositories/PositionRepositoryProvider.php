<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class PositionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\Position\PositionRepositoryInterface::class,
            \App\Domain\Repositories\Position\PositionRepositoryEloquent::class
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
