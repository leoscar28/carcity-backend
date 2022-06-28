<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\About\AboutCollection;
use App\Services\AboutService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected AboutService $aboutService;
    public function __construct(AboutService $aboutService)
    {
        $this->aboutService =   $aboutService;
    }

    public function get(): AboutCollection
    {
        return new AboutCollection($this->aboutService->get());
    }

}
