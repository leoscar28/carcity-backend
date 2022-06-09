<?php

namespace App\Models;

use App\Domain\Contracts\RoomTypeContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   RoomTypeContract::FILLABLE;
}
