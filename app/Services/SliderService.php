<?php

namespace App\Services;

use App\Domain\Repositories\Slider\SliderRepositoryInterface;

class SliderService
{
    protected SliderRepositoryInterface $sliderRepository;
    public function __construct(SliderRepositoryInterface $sliderRepository)
    {
        $this->sliderRepository =   $sliderRepository;
    }

    public function get()
    {
        return $this->sliderRepository->get();
    }

}
