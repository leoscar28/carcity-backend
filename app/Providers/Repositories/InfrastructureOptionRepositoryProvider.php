<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class InfrastructureOptionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\InfrastructureOption\InfrastructureOptionRepositoryInterface::class,
            \App\Domain\Repositories\InfrastructureOption\InfrastructureOptionRepositoryEloquent::class
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
