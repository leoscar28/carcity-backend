<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class CompletionSignatureRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\CompletionSignature\CompletionSignatureRepositoryInterface::class,
            \App\Domain\Repositories\CompletionSignature\CompletionSignatureRepositoryEloquent::class
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
