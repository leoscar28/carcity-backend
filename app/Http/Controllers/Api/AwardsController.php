<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Awards\AwardsCollection;
use App\Services\AwardsService;
use Illuminate\Http\Request;

class AwardsController extends Controller
{
    protected AwardsService $awardsService;
    public function __construct(AwardsService $awardsService)
    {
        $this->awardsService    =   $awardsService;
    }

    public function get(): AwardsCollection
    {
        return new AwardsCollection($this->awardsService->get());
    }

}
