<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class TierRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Tier\TierRepositoryInterface::class,
            \App\Domain\Repositories\Tier\TierRepositoryEloquent::class
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
