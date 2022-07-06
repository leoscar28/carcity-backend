<?php

namespace App\Models;

use App\Domain\Contracts\DictionaryBrandContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictionaryBrand extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable =   DictionaryBrandContract::FILLABLE;
}
