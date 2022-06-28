<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutOption\AboutOptionCollection;
use App\Services\AboutOptionService;
use Illuminate\Http\Request;

class AboutOptionController extends Controller
{
    protected AboutOptionService $aboutOptionService;
    public function __construct(AboutOptionService $aboutOptionService)
    {
        $this->aboutOptionService   =   $aboutOptionService;
    }

    public function get(): AboutOptionCollection
    {
        return new AboutOptionCollection($this->aboutOptionService->get());
    }

}
