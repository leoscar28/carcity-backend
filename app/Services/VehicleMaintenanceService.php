<?php

namespace App\Services;

use App\Domain\Repositories\VehicleMaintenance\VehicleMaintenanceRepositoryInterface;

class VehicleMaintenanceService
{
    protected VehicleMaintenanceRepositoryInterface $vehicleMaintenanceRepository;
    public function __construct(VehicleMaintenanceRepositoryInterface $vehicleMaintenanceRepository)
    {
        $this->vehicleMaintenanceRepository =   $vehicleMaintenanceRepository;
    }

    public function get()
    {
        return $this->vehicleMaintenanceRepository->get();
    }

}
