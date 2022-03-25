<?php

namespace App\Models;

use App\Domain\Contracts\ApplicationStatusContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable =   ApplicationStatusContract::FILLABLE;
}
