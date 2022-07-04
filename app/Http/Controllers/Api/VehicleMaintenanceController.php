<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleMaintenance\VehicleMaintenanceCollection;
use App\Services\VehicleMaintenanceService;
use Illuminate\Http\Request;

class VehicleMaintenanceController extends Controller
{
    protected VehicleMaintenanceService $vehicleMaintenanceService;
    public function __construct(VehicleMaintenanceService $vehicleMaintenanceService)
    {
        $this->vehicleMaintenanceService    =   $vehicleMaintenanceService;
    }

    public function get(): VehicleMaintenanceCollection
    {
        return new VehicleMaintenanceCollection($this->vehicleMaintenanceService->get());
    }

}
