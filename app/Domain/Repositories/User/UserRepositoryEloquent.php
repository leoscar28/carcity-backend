<?php

namespace App\Domain\Repositories\User;

use App\Domain\Contracts\MainContract;
use App\Models\User;

class UserRepositoryEloquent implements UserRepositoryInterface
{

    public function getByPhoneOrEmailOrAlias($login): object|null
    {
        return User::with(MainContract::ROLES,MainContract::POSITIONS)
            ->where($login)
            ->first();
    }

    public function update($id,$data): ?object
    {
        $user   =   User::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getById($id): object|null
    {
        return User::with(MainContract::ROLES,MainContract::POSITIONS)
            ->where([
                [MainContract::ID,$id],
                [MainContract::STATUS,1]
            ])->first();
    }

    public function getByToken($token): object|null
    {
        return User::with(MainContract::ROLES,MainContract::POSITIONS)
            ->where([
                [MainContract::TOKEN,$token],
                [MainContract::STATUS,MainContract::TRUE]
            ])
            ->first();
    }
}
