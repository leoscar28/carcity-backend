<?php

namespace App\Domain\Repositories\Slider;

use App\Domain\Contracts\MainContract;
use App\Models\Slider;

class SliderRepositoryEloquent implements SliderRepositoryInterface
{
    public function get()
    {
        return Slider::where(MainContract::STATUS,1)->get();
    }
}
