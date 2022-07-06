<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class DictionaryBrandRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\DictionaryBrand\DictionaryBrandRepositoryInterface::class,
            \App\Domain\Repositories\DictionaryBrand\DictionaryBrandRepositoryEloquent::class,
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
