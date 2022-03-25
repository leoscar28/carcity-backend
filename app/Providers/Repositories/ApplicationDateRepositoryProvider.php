<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class ApplicationDateRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\ApplicationDate\ApplicationDateRepositoryInterface::class,
            \App\Domain\Repositories\ApplicationDate\ApplicationDateRepositoryEloquent::class
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
