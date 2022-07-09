<?php

namespace App\Models;

use App\Domain\Contracts\PrivacyPolicyContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   PrivacyPolicyContract::TABLE;
    protected $fillable =   PrivacyPolicyContract::FILLABLE;
}
