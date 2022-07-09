<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Rule\RuleCollection;
use App\Services\RuleService;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    protected RuleService $ruleService;
    public function __construct(RuleService $ruleService)
    {
        $this->ruleService  =   $ruleService;
    }

    public function get(): RuleCollection
    {
        return new RuleCollection($this->ruleService->get());
    }

}
