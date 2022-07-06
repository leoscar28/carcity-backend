<?php

namespace App\Models;

use App\Domain\Contracts\DictionarySparePartContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictionarySparePart extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable =   DictionarySparePartContract::FILLABLE;
}
