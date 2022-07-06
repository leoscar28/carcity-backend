<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class DictionaryServiceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\DictionaryService\DictionaryServiceRepositoryInterface::class,
            \App\Domain\Repositories\DictionaryService\DictionaryServiceRepositoryEloquent::class,
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
