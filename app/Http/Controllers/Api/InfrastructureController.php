<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Infrastructure\InfrastructureCollection;
use App\Services\InfrastructureService;
use Illuminate\Http\Request;

class InfrastructureController extends Controller
{
    protected InfrastructureService $infrastructureService;
    public function __construct(InfrastructureService $infrastructureService)
    {
        $this->infrastructureService    =   $infrastructureService;
    }

    public function get(): InfrastructureCollection
    {
        return new InfrastructureCollection($this->infrastructureService->get());
    }

}
