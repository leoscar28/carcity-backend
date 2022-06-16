<?php

namespace App\Http\Resources\Room;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\RoomType\RoomTypeResource;
use App\Http\Resources\Tier\TierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::TIER  =>  new TierResource($this->{MainContract::TIER}),
            MainContract::ROOM_TYPE =>  new RoomTypeResource($this->{MainContract::ROOM_TYPE}),
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
