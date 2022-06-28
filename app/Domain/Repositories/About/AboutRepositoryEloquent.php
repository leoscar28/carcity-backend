<?php

namespace App\Domain\Repositories\About;

use App\Domain\Contracts\MainContract;
use App\Models\About;

class AboutRepositoryEloquent implements AboutRepositoryInterface
{
    public function get()
    {
        return About::where(MainContract::STATUS,1)->get();
    }
}
