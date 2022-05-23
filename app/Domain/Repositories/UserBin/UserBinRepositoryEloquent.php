<?php

namespace App\Domain\Repositories\UserBin;

use App\Domain\Contracts\MainContract;
use App\Models\UserBin;

class UserBinRepositoryEloquent implements UserBinRepositoryInterface
{
    public function getByIin($bin)
    {
        return UserBin::where([
            [MainContract::IIN,$bin],
            [MainContract::STATUS,1]
        ])->get();
    }
}
