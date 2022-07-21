<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
use App\Domain\Contracts\UserReviewContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable =   UserContract::FILLABLE;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden   =   UserContract::HIDDEN;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts    =   UserContract::CASTS;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function roles(): BelongsTo
    {
        return $this->belongsTo(Role::class,MainContract::ROLE_ID,MainContract::ID);
    }

    public function positions(): BelongsTo
    {
        return $this->belongsTo(Position::class,MainContract::POSITION_ID,MainContract::ID);
    }

    public function reviewsOnMe(){
        return $this->hasMany(UserReview::class, MainContract::CUSTOMER_ID,MainContract::ID)->where([MainContract::STATUS => UserReviewContract::STATUS_ACTIVE]);
    }

    public function reviewsOnMeCounter(){
        $rating = $this->reviewsOnMe()->avg(MainContract::RATING);
        $counts = $this->reviewsOnMe()->count();
        return ['rating' => $rating, 'count' => $counts];
    }

    public function reviews(){
        return $this->hasMany(UserReview::class, MainContract::USER_ID,MainContract::ID)->where([MainContract::STATUS => UserReviewContract::STATUS_INACTIVE]);
    }

    public function favorites(){
        return $this->hasMany(UserFavorite::class, MainContract::USER_ID,MainContract::ID);
    }

    public function favoriteIds(){
        return $this->favorites->pluck('id');
    }

    public function requests(){
        return $this->hasMany(UserRequest::class, MainContract::USER_ID,MainContract::ID);
    }

    public function sparePart(){
        return $this->hasOne(DictionarySparePart::class, MainContract::ID,MainContract::SPARE_PART_ID);
    }

    public function brand(){
        return $this->hasOne(DictionaryBrand::class, MainContract::ID,MainContract::BRAND_ID);
    }

    public function service(){
        return $this->hasOne(DictionaryService::class, MainContract::ID,MainContract::SERVICE_ID);
    }
}
