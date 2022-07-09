<?php

namespace App\Models;

use App\Domain\Contracts\InstructionContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use CrudTrait, HasFactory;
    protected $table    =   InstructionContract::TABLE;
    protected $fillable =   InstructionContract::FILLABLE;
}
