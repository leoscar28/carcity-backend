<?php

namespace App\Domain\Contracts;

class VehicleMaintenanceContract extends MainContract
{
    const TABLE =   'vehicle_maintenances';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::IMG,
        self::STATUS,
    ];
}
