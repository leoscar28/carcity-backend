<?php

namespace App\Models;

use App\Domain\Contracts\TermsOfUseContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsOfUse extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   TermsOfUseContract::TABLE;
    protected $fillable =   TermsOfUseContract::FILLABLE;
}
