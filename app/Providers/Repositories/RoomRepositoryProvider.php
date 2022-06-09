<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class RoomRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Room\RoomRepositoryInterface::class,
            \App\Domain\Repositories\Room\RoomRepositoryEloquent::class
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
