<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Slider\SliderCollection;
use App\Services\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected SliderService $sliderService;
    public function __construct(SliderService $sliderService)
    {
        $this->sliderService    =   $sliderService;
    }

    public function get(): SliderCollection
    {
        return new SliderCollection($this->sliderService->get());
    }

}
