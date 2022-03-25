<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class InvoiceDateRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\InvoiceDate\InvoiceDateRepositoryInterface::class,
            \App\Domain\Repositories\InvoiceDate\InvoiceDateRepositoryEloquent::class
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
