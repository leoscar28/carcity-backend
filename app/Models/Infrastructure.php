<?php

namespace App\Models;

use App\Domain\Contracts\InfrastructureContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infrastructure extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   InfrastructureContract::FILLABLE;
}
