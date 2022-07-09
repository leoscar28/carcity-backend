<?php

namespace App\Domain\Repositories\Rule;

use App\Domain\Contracts\MainContract;
use App\Models\Rule;

class RuleRepositoryEloquent implements RuleRepositoryInterface
{
    public function get()
    {
        return Rule::where(MainContract::STATUS,1)->get();
    }
}
