<?php

namespace App\Models;

use App\Domain\Contracts\InfrastructureOptionContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class InfrastructureOption extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   InfrastructureOptionContract::TABLE;
    protected $fillable =   InfrastructureOptionContract::FILLABLE;

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
