<?php

namespace App\Domain\Repositories\User;

use App\Domain\Contracts\MainContract;
use App\Models\User;

class UserRepositoryEloquent implements UserRepositoryInterface
{
    public function getByToken($token)
    {
        return User::where([
            [MainContract::TOKEN,$token],
            [MainContract::STATUS,MainContract::TRUE]
        ])->first();
    }
}
