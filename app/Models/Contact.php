<?php

namespace App\Models;

use App\Domain\Contracts\ContactContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   ContactContract::TABLE;
    protected $fillable =   ContactContract::FILLABLE;
}
