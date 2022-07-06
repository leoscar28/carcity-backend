<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class UserReviewRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\UserReview\UserReviewRepositoryInterface::class,
            \App\Domain\Repositories\UserReview\UserReviewRepositoryEloquent::class
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
