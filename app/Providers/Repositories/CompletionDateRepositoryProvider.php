<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class CompletionDateRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\CompletionDate\CompletionDateRepositoryInterface::class,
            \App\Domain\Repositories\CompletionDate\CompletionDateRepositoryEloquent::class,
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
