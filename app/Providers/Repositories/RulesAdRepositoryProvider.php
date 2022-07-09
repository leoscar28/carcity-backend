<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class RulesAdRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\RulesAd\RulesAdRepositoryInterface::class,
            \App\Domain\Repositories\RulesAd\RulesAdRepositoryEloquent::class,
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
