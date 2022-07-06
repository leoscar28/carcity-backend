<?php

namespace App\Models;

use App\Domain\Contracts\UserFavoriteContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    use HasFactory;

    protected $table = UserFavoriteContract::TABLE;
    protected $fillable =   UserFavoriteContract::FILLABLE;
}

