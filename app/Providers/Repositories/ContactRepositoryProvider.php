<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class ContactRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Contact\ContactRepositoryInterface::class,
            \App\Domain\Repositories\Contact\ContactRepositoryEloquent::class
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
