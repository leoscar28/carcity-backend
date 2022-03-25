<?php

namespace App\Http\Resources\User;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\Position\PositionResource;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ROLES =>  new RoleResource($this->whenLoaded(MainContract::ROLES)),
            MainContract::POSITIONS =>  new PositionResource($this->whenLoaded(MainContract::POSITIONS)),
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::TOKEN =>  $this->{MainContract::TOKEN},
            MainContract::NAME  =>  $this->{MainContract::NAME},
            MainContract::SURNAME   =>  $this->{MainContract::SURNAME},
            MainContract::BIRTHDATE =>  $this->{MainContract::BIRTHDATE},
            MainContract::HIDE_BIRTHDATE    =>  $this->{MainContract::HIDE_BIRTHDATE},
            MainContract::ROLE_ID   =>  $this->{MainContract::ROLE_ID},
            MainContract::COMPANY   =>  $this->{MainContract::COMPANY},
            MainContract::BIN   =>  $this->{MainContract::BIN},
            MainContract::EMAIL =>  $this->{MainContract::EMAIL},
            MainContract::EMAIL_VERIFIED_AT =>  $this->{MainContract::EMAIL_VERIFIED_AT},
            MainContract::PHONE =>  $this->{MainContract::PHONE},
            MainContract::PHONE_VERIFIED_AT =>  $this->{MainContract::PHONE_VERIFIED_AT},
        ];
    }
}
