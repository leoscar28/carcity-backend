<?php

namespace App\Domain\Repositories\VehicleMaintenance;

use App\Domain\Contracts\MainContract;
use App\Models\VehicleMaintenance;

class VehicleMaintenanceRepositoryEloquent implements VehicleMaintenanceRepositoryInterface
{
    public function get()
    {
        return VehicleMaintenance::where(MainContract::STATUS,1)->get();
    }
}
