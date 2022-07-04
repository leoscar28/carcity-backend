<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class VehicleMaintenanceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\VehicleMaintenance\VehicleMaintenanceRepositoryInterface::class,
            \App\Domain\Repositories\VehicleMaintenance\VehicleMaintenanceRepositoryEloquent::class
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
