<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class PrivacyPolicyRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\PrivacyPolicy\PrivacyPolicyRepositoryInterface::class,
            \App\Domain\Repositories\PrivacyPolicy\PrivacyPolicyRepositoryEloquent::class
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
