<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class CompletionStatusRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\CompletionStatus\CompletionStatusRepositoryInterface::class,
            \App\Domain\Repositories\CompletionStatus\CompletionStatusRepositoryEloquent::class,
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
