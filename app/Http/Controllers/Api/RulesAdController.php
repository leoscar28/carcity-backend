<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RulesAd\RulesAdCollection;
use App\Services\RulesAdService;
use Illuminate\Http\Request;

class RulesAdController extends Controller
{
    protected RulesAdService $rulesAdService;
    public function __construct(RulesAdService $rulesAdService)
    {
        $this->rulesAdService   =   $rulesAdService;
    }

    public function get(): RulesAdCollection
    {
        return new RulesAdCollection($this->rulesAdService->get());
    }

}
