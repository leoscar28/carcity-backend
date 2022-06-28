<?php

namespace App\Domain\Repositories\AboutOption;

use App\Domain\Contracts\MainContract;
use App\Models\AboutOption;

class AboutOptionRepositoryEloquent implements AboutOptionRepositoryInterface
{
    public function get()
    {
        return AboutOption::where(MainContract::STATUS,1)->get();
    }
}
