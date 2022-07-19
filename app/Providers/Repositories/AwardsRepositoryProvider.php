<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class AwardsRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Awards\AwardsRepositoryInterface::class,
            \App\Domain\Repositories\Awards\AwardsRepositoryEloquent::class
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
