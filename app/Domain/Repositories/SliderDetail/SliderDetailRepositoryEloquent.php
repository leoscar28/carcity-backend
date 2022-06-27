<?php

namespace App\Domain\Repositories\SliderDetail;

use App\Domain\Contracts\MainContract;
use App\Models\SliderDetail;

class SliderDetailRepositoryEloquent implements SliderDetailRepositoryInterface
{
    public function get()
    {
        return SliderDetail::where(MainContract::STATUS,1)->get();
    }
}
