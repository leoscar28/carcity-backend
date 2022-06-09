<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class RoomTypeRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\RoomType\RoomTypeRepositoryInterface::class,
            \App\Domain\Repositories\RoomType\RoomTypeRepositoryEloquent::class
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
