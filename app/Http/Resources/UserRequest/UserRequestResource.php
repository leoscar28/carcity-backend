<?php

namespace App\Http\Resources\UserRequest;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRequestResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::USER_ID =>  $this->{MainContract::USER_ID},
            MainContract::USER =>  $this->{MainContract::USER},
            MainContract::PHONE =>  $this->{MainContract::PHONE},
            MainContract::BRAND_ID =>  $this->{MainContract::BRAND_ID},
            MainContract::BRAND =>  $this->{MainContract::BRAND},
            MainContract::CATEGORY_ID =>  $this->{MainContract::CATEGORY_ID},
            MainContract::CATEGORY =>  $this->{MainContract::CATEGORY},
            MainContract::DESCRIPTION =>  $this->{MainContract::DESCRIPTION},
            MainContract::STATUS =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT =>  $this->{MainContract::CREATED_AT},
            MainContract::UPDATED_AT =>  $this->{MainContract::UPDATED_AT}
        ];
    }
}
