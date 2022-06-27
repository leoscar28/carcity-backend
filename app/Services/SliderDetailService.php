<?php

namespace App\Services;

use App\Domain\Repositories\SliderDetail\SliderDetailRepositoryInterface;

class SliderDetailService
{
    protected SliderDetailRepositoryInterface $sliderDetailRepository;
    public function __construct(SliderDetailRepositoryInterface $sliderDetailRepository)
    {
        $this->sliderDetailRepository   =   $sliderDetailRepository;
    }

    public function get()
    {
        return $this->sliderDetailRepository->get();
    }

}
