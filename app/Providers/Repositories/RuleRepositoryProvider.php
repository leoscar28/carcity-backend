<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class RuleRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Rule\RuleRepositoryInterface::class,
            \App\Domain\Repositories\Rule\RuleRepositoryEloquent::class
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
