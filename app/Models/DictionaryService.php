<?php

namespace App\Models;

use App\Domain\Contracts\DictionaryServiceContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictionaryService extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable =   DictionaryServiceContract::FILLABLE;
}
