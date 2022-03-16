<?php

namespace App\Domain\Repositories\User;

use App\Domain\Contracts\MainContract;
use App\Models\User;

class UserRepositoryEloquent implements UserRepositoryInterface
{

    public function getByPhoneOrEmailOrAlias($login): object|null
    {
        return User::with(MainContract::ROLES)
            ->where($login)
            ->first();
    }

    public function getByToken($token): object|null
    {
        return User::with(MainContract::ROLES)
            ->where([
                [MainContract::TOKEN,$token],
                [MainContract::STATUS,MainContract::TRUE]
            ])
            ->first();
    }
}
