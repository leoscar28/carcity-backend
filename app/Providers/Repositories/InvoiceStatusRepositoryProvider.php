<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class InvoiceStatusRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\InvoiceStatus\InvoiceStatusRepositoryInterface::class,
            \App\Domain\Repositories\InvoiceStatus\InvoiceStatusRepositoryEloquent::class
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
