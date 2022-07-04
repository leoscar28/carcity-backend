<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InfrastructureOption\InfrastructureOptionCollection;
use App\Services\InfrastructureOptionService;
use Illuminate\Http\Request;

class InfrastructureOptionController extends Controller
{
    protected InfrastructureOptionService $infrastructureOptionService;
    public function __construct(InfrastructureOptionService $infrastructureOptionService)
    {
        $this->infrastructureOptionService  =   $infrastructureOptionService;
    }

    public function get(): InfrastructureOptionCollection
    {
        return new InfrastructureOptionCollection($this->infrastructureOptionService->get());
    }

}
