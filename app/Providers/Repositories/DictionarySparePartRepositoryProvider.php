<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class DictionarySparePartRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\DictionarySparePart\DictionarySparePartRepositoryInterface::class,
            \App\Domain\Repositories\DictionarySparePart\DictionarySparePartRepositoryEloquent::class,
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
