<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tier\TierCollection;
use App\Services\TierService;
use Illuminate\Http\Request;

class TierController extends Controller
{
    protected TierService $tierService;
    public function __construct(TierService $tierService)
    {
        $this->tierService  =   $tierService;
    }

    public function get(): TierCollection
    {
        return new TierCollection($this->tierService->get());
    }

}
