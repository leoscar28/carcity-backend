<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderDetail\SliderDetailCollection;
use App\Services\SliderDetailService;
use Illuminate\Http\Request;

class SliderDetailController extends Controller
{
    protected SliderDetailService $sliderDetailService;
    public function __construct(SliderDetailService $sliderDetailService)
    {
        $this->sliderDetailService  =   $sliderDetailService;
    }

    public function get(): SliderDetailCollection
    {
        return new SliderDetailCollection($this->sliderDetailService->get());
    }

}
