<?php

namespace App\Domain\Repositories\Infrastructure;

use App\Domain\Contracts\MainContract;
use App\Models\Infrastructure;

class InfrastructureRepositoryEloquent implements InfrastructureRepositoryInterface
{
    public function get()
    {
        return Infrastructure::where(MainContract::STATUS,1)->get();
    }
}
