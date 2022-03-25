<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Position\PositionCollection;
use App\Services\PositionService;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected PositionService $positionService;
    public function __construct(PositionService $positionService)
    {
        $this->positionService  =   $positionService;
    }

    public function list(): PositionCollection
    {
        return new PositionCollection($this->positionService->list());
    }

}
