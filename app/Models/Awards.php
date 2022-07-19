<?php

namespace App\Models;

use App\Domain\Contracts\AwardsContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Awards extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   AwardsContract::TABLE;
    protected $fillable =   AwardsContract::FILLABLE;

    public function setImgAttribute($value)
    {
        $disk   =   "public";
        $destination_path   =   "slider";
        $this->uploadFileToDisk($value, MainContract::IMG, $disk, $destination_path);
    }

    public function getImgAttribute($value): string
    {
        return URL::to('/').'/storage/'.$value;
    }

}
