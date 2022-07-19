<?php

namespace App\Domain\Repositories\Awards;

use App\Domain\Contracts\MainContract;
use App\Models\Awards;

class AwardsRepositoryEloquent implements AwardsRepositoryInterface
{
    public function get()
    {
        return Awards::where(MainContract::STATUS,1)->get();
    }
}
