<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserReviewContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    use HasFactory;

    protected $table = UserReviewContract::TABLE;
    protected $fillable = UserReviewContract::FILLABLE;

    public function user(){
        return $this->hasOne(User::class, MainContract::ID, MainContract::USER_ID)->select(['id', 'name', 'surname']);
    }

    public function customer(){
        return $this->hasOne(User::class, MainContract::ID, MainContract::CUSTOMER_ID)->select(['id', 'company']);
    }

    public function banner(){
        return $this->hasOne(UserBanner::class, MainContract::ID, MainContract::USER_BANNER_ID)->with(['images']);
    }
}
