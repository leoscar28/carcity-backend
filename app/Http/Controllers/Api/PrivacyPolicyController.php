<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrivacyPolicy\PrivacyPolicyCollection;
use App\Services\PrivacyPolicyService;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    protected PrivacyPolicyService $privacyPolicyService;
    public function __construct(PrivacyPolicyService $privacyPolicyService)
    {
        $this->privacyPolicyService =   $privacyPolicyService;
    }

    public function get(): PrivacyPolicyCollection
    {
        return new PrivacyPolicyCollection($this->privacyPolicyService->get());
    }

}
