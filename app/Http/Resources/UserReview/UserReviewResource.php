<?php

namespace App\Http\Resources\UserReview;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class UserReviewResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::USER_ID =>  $this->{MainContract::USER_ID},
            MainContract::USER =>  $this->{MainContract::USER},
            MainContract::CUSTOMER_ID =>  $this->{MainContract::CUSTOMER_ID},
            MainContract::USER_BANNER_ID =>  $this->{MainContract::USER_BANNER_ID},
            MainContract::USER_BANNER =>  $this->{MainContract::BANNER},
            MainContract::CUSTOMER =>  $this->{MainContract::CUSTOMER},
            MainContract::RATING =>  $this->{MainContract::RATING},
            MainContract::DESCRIPTION =>  $this->{MainContract::DESCRIPTION},
            MainContract::COMMENT =>  $this->{MainContract::COMMENT},
            MainContract::STATUS =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT =>  $this->{MainContract::CREATED_AT},
            MainContract::UPDATED_AT =>  $this->{MainContract::UPDATED_AT}
        ];
    }
}
