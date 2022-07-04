<?php

namespace App\Http\Resources\VehicleMaintenance;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class VehicleMaintenanceCollection extends ResourceCollection
{
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new VehicleMaintenanceResource($request);
        });
    }
}
