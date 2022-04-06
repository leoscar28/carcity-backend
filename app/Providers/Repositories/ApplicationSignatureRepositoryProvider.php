<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class ApplicationSignatureRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\ApplicationSignature\ApplicationSignatureRepositoryInterface::class,
            \App\Domain\Repositories\ApplicationSignature\ApplicationSignatureRepositoryEloquent::class
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
