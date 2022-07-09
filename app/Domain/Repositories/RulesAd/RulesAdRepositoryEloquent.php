<?php

namespace App\Domain\Repositories\RulesAd;

use App\Domain\Contracts\MainContract;
use App\Models\RulesAd;

class RulesAdRepositoryEloquent implements RulesAdRepositoryInterface
{
    public function get()
    {
        return RulesAd::where(MainContract::STATUS,1)->get();
    }
}
