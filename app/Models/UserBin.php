<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserBinContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBin extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   UserBinContract::FILLABLE;
}
