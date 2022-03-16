<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class ApplicationListRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\ApplicationList\ApplicationListRepositoryInterface::class,
            \App\Domain\Repositories\ApplicationList\ApplicationListRepositoryEloquent::class
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
