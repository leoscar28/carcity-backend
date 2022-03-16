<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class InvoiceListRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\InvoiceList\InvoiceListRepositoryInterface::class,
            \App\Domain\Repositories\InvoiceList\InvoiceListRepositoryEloquent::class,
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
