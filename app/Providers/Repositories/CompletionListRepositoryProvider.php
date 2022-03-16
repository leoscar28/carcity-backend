<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class CompletionListRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\CompletionList\CompletionListRepositoryInterface::class,
            \App\Domain\Repositories\CompletionList\CompletionListRepositoryEloquent::class
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
