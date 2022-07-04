<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\VehicleMaintenanceContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class VehicleMaintenance extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   VehicleMaintenanceContract::TABLE;
    protected $fillable =   VehicleMaintenanceContract::FILLABLE;

    public function setImgAttribute($value)
    {
        $disk   =   "public";
        $destination_path   =   "icon";
        $this->uploadFileToDisk($value, MainContract::IMG, $disk, $destination_path);
    }

    public function getImgAttribute($value): string
    {
        return URL::to('/').'/storage/'.$value;
    }

}
