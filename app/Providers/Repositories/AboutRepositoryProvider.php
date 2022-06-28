<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class AboutRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\About\AboutRepositoryInterface::class,
            \App\Domain\Repositories\About\AboutRepositoryEloquent::class
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
