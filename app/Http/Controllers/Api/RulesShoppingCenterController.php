<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RulesShoppingCenter\RulesShoppingCenterCollection;
use App\Services\RulesShoppingCenterService;
use Illuminate\Http\Request;

class RulesShoppingCenterController extends Controller
{
    protected RulesShoppingCenterService $rulesShoppingCenterService;
    public function __construct(RulesShoppingCenterService $rulesShoppingCenterService)
    {
        $this->rulesShoppingCenterService   =   $rulesShoppingCenterService;
    }

    public function get(): RulesShoppingCenterCollection
    {
        return new RulesShoppingCenterCollection($this->rulesShoppingCenterService->get());
    }

}
