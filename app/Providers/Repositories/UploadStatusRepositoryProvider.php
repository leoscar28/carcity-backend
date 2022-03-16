<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class UploadStatusRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Domain\Repositories\UploadStatus\UploadStatusRepositoryInterface::class,
            \App\Domain\Repositories\UploadStatus\UploadStatusRepositoryEloquent::class
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
