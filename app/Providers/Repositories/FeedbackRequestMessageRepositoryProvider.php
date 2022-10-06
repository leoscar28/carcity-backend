<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class FeedbackRequestMessageRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\FeedbackRequestMessage\FeedbackRequestMessageRepositoryInterface::class,
            \App\Domain\Repositories\FeedbackRequestMessage\FeedbackRequestMessageRepositoryEloquent::class
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
