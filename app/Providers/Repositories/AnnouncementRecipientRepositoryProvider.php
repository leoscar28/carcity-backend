<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class AnnouncementRecipientRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\AnnouncementRecipient\AnnouncementRecipientRepositoryInterface::class,
            \App\Domain\Repositories\AnnouncementRecipient\AnnouncementRecipientRepositoryEloquent::class
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
