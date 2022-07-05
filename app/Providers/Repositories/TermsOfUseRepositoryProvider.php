<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class TermsOfUseRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\TermsOfUse\TermsOfUseRepositoryInterface::class,
            \App\Domain\Repositories\TermsOfUse\TermsOfUseRepositoryEloquent::class
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
