<?php

namespace App\Models;

use App\Domain\Contracts\RuleContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   RuleContract::TABLE;
    protected $fillable =   RuleContract::FILLABLE;
}
