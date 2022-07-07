<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class RulesShoppingCenterRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\RulesShoppingCenter\RulesShoppingCenterRepositoryInterface::class,
            \App\Domain\Repositories\RulesShoppingCenter\RulesShoppingCenterRepositoryEloquent::class
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
