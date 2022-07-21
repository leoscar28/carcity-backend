<?php

namespace App\Http\Resources\UserBanner;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBannerResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::USER_ID =>  $this->{MainContract::USER_ID},
            MainContract::USER =>  $this->{MainContract::USER},
            MainContract::TYPE =>  $this->{MainContract::TYPE},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::DESCRIPTION =>  $this->{MainContract::DESCRIPTION},
            MainContract::CATEGORY_ID =>  $this->{MainContract::CATEGORY_ID},
            MainContract::BRAND_ID =>  $this->{MainContract::BRAND_ID},
            MainContract::TIME =>  $this->{MainContract::TIME},
            MainContract::WEEKDAYS =>  $this->{MainContract::WEEKDAYS},
            MainContract::EMPLOYEE_NAME =>  $this->{MainContract::EMPLOYEE_NAME},
            MainContract::EMPLOYEE_PHONE =>  $this->{MainContract::EMPLOYEE_PHONE},
            MainContract::EMPLOYEE_NAME_ADDITIONAL =>  $this->{MainContract::EMPLOYEE_NAME_ADDITIONAL} ?: '',
            MainContract::EMPLOYEE_PHONE_ADDITIONAL =>  $this->{MainContract::EMPLOYEE_PHONE_ADDITIONAL} ?: '',
            MainContract::IMAGES =>  $this->{MainContract::IMAGES},
            MainContract::REVIEWS => $this->{MainContract::USER}->reviewsOnMeCounter(),
            MainContract::REVIEW_ITEMS => $this->{MainContract::REVIEWS},
            MainContract::ROOM_ID =>  $this->{MainContract::ROOM_ID},
            MainContract::ROOM =>  $this->{MainContract::ROOM},
            MainContract::COMMENT =>  $this->{MainContract::COMMENT},
            MainContract::STATUS =>  $this->{MainContract::STATUS},
            MainContract::IS_PUBLISHED =>  $this->{MainContract::IS_PUBLISHED},
            MainContract::VIEW_COUNT => $this->{MainContract::VIEW_COUNT},
            MainContract::PHONE_VIEW_COUNT => $this->{MainContract::PHONE_VIEW_COUNT},
            MainContract::CREATED_AT =>  $this->{MainContract::CREATED_AT},
            MainContract::UPDATED_AT =>  $this->{MainContract::UPDATED_AT},
            MainContract::PUBLISHED_AT =>  date('y/M/d',strtotime($this->{MainContract::PUBLISHED_AT})).'T'.date('H:m',strtotime($this->{MainContract::PUBLISHED_AT})),
            MainContract::UP =>  $this->{MainContract::UP},
        ];
    }
}
