<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class SliderRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Slider\SliderRepositoryInterface::class,
            \App\Domain\Repositories\Slider\SliderRepositoryEloquent::class,
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
