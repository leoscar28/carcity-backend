<?php

namespace App\Models;

use App\Domain\Contracts\AboutContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   AboutContract::TABLE;
    protected $fillable =   AboutContract::FILLABLE;
}
