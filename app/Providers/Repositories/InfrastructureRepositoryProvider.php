<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class InfrastructureRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Infrastructure\InfrastructureRepositoryInterface::class,
            \App\Domain\Repositories\Infrastructure\InfrastructureRepositoryEloquent::class
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
