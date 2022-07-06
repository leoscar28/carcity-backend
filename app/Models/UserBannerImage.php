<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBannerImage extends Model
{
    use HasFactory;

    protected $table = 'user_banner_images';

    protected $fillable = [
        MainContract::USER_BANNER_ID,
        MainContract::TITLE,
        MainContract::PATH
    ];


    protected $hidden = [MainContract::CREATED_AT, MainContract::UPDATED_AT];

}
