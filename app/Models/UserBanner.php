<?php

namespace App\Models;

use App\Casts\Json;
use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserBannerContract;
use App\Domain\Contracts\UserReviewContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBanner extends Model
{
    use HasFactory;

    protected $fillable =   UserBannerContract::FILLABLE;

    protected $casts = [
        MainContract::CATEGORY_ID => Json::class,
        MainContract::BRAND_ID => Json::class,
        MainContract::TIME => Json::class,
        MainContract::WEEKDAYS => Json::class,
    ];

    public function images(){
        return $this->hasMany(UserBannerImage::class);
    }

    public function room(){
        return $this->hasOne(Room::class, MainContract::ID, MainContract::ROOM_ID)->with(['RoomType','tier']);
    }

    public function user(){
        return $this->hasOne(User::class, MainContract::ID, MainContract::USER_ID)->select(['id', 'company']);
    }

    public function reviews(){
        return $this->hasMany(UserReview::class, MainContract::USER_BANNER_ID,MainContract::ID)->where([MainContract::STATUS => UserReviewContract::STATUS_ACTIVE])->with(['user']);
    }

    public function reviewsOnUser(){
        return $this->hasMany(UserReview::class, MainContract::CUSTOMER_ID,MainContract::USER_ID)->where([MainContract::STATUS => UserReviewContract::STATUS_ACTIVE]);
    }

    public function reviewsCounter(){
        $rating = $this->reviews()->avg(MainContract::RATING);
        $counts = $this->reviews()->count();
        return ['rating' => $rating, 'count' => $counts];
    }
}
