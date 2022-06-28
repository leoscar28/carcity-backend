<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class AboutOptionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\AboutOption\AboutOptionRepositoryInterface::class,
            \App\Domain\Repositories\AboutOption\AboutOptionRepositoryEloquent::class,
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
