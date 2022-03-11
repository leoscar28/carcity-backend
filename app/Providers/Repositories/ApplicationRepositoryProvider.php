<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class ApplicationRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\Application\ApplicationRepositoryInterface::class,
            \App\Domain\Repositories\Application\ApplicationRepositoryEloquent::class
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
