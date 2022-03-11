<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class InvoiceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\Invoice\InvoiceRepositoryInterface::class,
            \App\Domain\Repositories\Invoice\InvoiceRepositoryEloquent::class
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
