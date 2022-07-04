<?php

namespace App\Domain\Repositories\InfrastructureOption;

use App\Domain\Contracts\MainContract;
use App\Models\InfrastructureOption;

class InfrastructureOptionRepositoryEloquent implements InfrastructureOptionRepositoryInterface
{
    public function get()
    {
        return InfrastructureOption::where(MainContract::STATUS,1)->get();
    }
}
