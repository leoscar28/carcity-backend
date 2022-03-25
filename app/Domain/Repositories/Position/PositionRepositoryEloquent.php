<?php

namespace App\Domain\Repositories\Position;

use App\Domain\Contracts\MainContract;
use App\Models\Position;

class PositionRepositoryEloquent implements PositionRepositoryInterface
{
    public function list()
    {
        return Position::where(MainContract::STATUS,1)->get();
    }
}
