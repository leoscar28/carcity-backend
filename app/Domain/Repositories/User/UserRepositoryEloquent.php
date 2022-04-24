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
        User::where(MainContract::ID,$id)->update($data);
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

    public function getByRoleIds($ids)
    {
        return User::whereIn(MainContract::ROLE_ID,$ids)->get();
    }

    public function getByBin($bin)
    {
        return User::where([
            [MainContract::BIN,$bin],
            [MainContract::STATUS,1]
        ])->first();
    }


    public function getByPhone($phone): object|null
    {
        return User::with(MainContract::ROLES,MainContract::POSITIONS)
            ->where([
                [MainContract::PHONE,$phone],
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
