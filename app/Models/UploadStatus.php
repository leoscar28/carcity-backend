<?php

namespace App\Models;

use App\Domain\Contracts\UploadStatusContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadStatus extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable =   UploadStatusContract::FILLABLE;
}
