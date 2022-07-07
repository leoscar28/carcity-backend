<?php

namespace App\Domain\Repositories\RulesShoppingCenter;

use App\Domain\Contracts\MainContract;
use App\Models\RulesShoppingCenter;

class RulesShoppingCenterRepositoryEloquent implements RulesShoppingCenterRepositoryInterface
{
    public function get()
    {
        return RulesShoppingCenter::where(MainContract::STATUS,1)->get();
    }
}
