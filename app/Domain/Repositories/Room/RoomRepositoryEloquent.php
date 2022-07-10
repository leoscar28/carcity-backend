<?php

namespace App\Domain\Repositories\Room;

use App\Domain\Contracts\MainContract;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class RoomRepositoryEloquent implements RoomRepositoryInterface
{
    public function getByUserId($userId): Collection|array
    {
        return Room::with('RoomType','tier')
            ->where(MainContract::USER_ID,$userId)
            ->get();
    }

    public function get()
    {
        return Room::with('RoomType','tier')
            ->where(MainContract::STATUS,'!=',0)
            ->get();
    }

}
