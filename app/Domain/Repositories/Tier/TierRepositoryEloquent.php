<?php

namespace App\Domain\Repositories\Tier;

use App\Domain\Contracts\MainContract;
use App\Models\Tier;

class TierRepositoryEloquent implements TierRepositoryInterface
{
    public function get()
    {
        return Tier::where(MainContract::STATUS,1)->get();
    }
}
