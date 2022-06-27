<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\SliderContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Slider extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   SliderContract::TABLE;
    protected $fillable =   SliderContract::FILLABLE;

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
