<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class AnnouncementRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\Announcement\AnnouncementRepositoryInterface::class,
            \App\Domain\Repositories\Announcement\AnnouncementRepositoryEloquent::class
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
