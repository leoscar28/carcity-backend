<?php

namespace App\Models;

use App\Domain\Contracts\RulesAdContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RulesAd extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   RulesAdContract::TABLE;
    protected $fillable =   RulesAdContract::FILLABLE;
}
