<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class ApplicationStatusRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\ApplicationStatus\ApplicationStatusRepositoryInterface::class,
            \App\Domain\Repositories\ApplicationStatus\ApplicationStatusRepositoryEloquent::class
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
