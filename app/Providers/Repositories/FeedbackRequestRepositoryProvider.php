<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class FeedbackRequestRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\FeedbackRequest\FeedbackRequestRepositoryInterface::class,
            \App\Domain\Repositories\FeedbackRequest\FeedbackRequestRepositoryEloquent::class
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
