<?php

namespace App\Domain\Repositories\Role;

use App\Domain\Contracts\MainContract;
use App\Models\Role;

class RoleRepositoryEloquent implements RoleRepositoryInterface
{
    public function list()
    {
        return Role::where(MainContract::STATUS,1)->get();
    }
}
