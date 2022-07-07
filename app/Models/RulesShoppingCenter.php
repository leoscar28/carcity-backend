<?php

namespace App\Models;

use App\Domain\Contracts\RulesShoppingCenterContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RulesShoppingCenter extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   RulesShoppingCenterContract::TABLE;
    protected $fillable =   RulesShoppingCenterContract::FILLABLE;
}
