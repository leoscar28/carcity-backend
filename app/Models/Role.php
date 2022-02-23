<?php

namespace App\Models;

use App\Domain\Contracts\RoleContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable =   RoleContract::FILLABLE;
}
