<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TierService;
use Illuminate\Http\Request;

class TierController extends Controller
{
    protected TierService $tierService;
    public function __construct(TierService $tierService)
    {
        $this->tierService  =   $tierService;
    }
}
