<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class CompletionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\Completion\CompletionRepositoryInterface::class,
            \App\Domain\Repositories\Completion\CompletionRepositoryEloquent::class,
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
