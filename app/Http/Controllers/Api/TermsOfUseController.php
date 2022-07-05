<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TermsOfUse\TermsOfUserCollection;
use App\Services\TermsOfUseService;
use Illuminate\Http\Request;

class TermsOfUseController extends Controller
{
    protected TermsOfUseService $termsOfUseService;
    public function __construct(TermsOfUseService $termsOfUseService)
    {
        $this->termsOfUseService    =   $termsOfUseService;
    }

    public function get(): TermsOfUserCollection
    {
        return new TermsOfUserCollection($this->termsOfUseService->get());
    }

}
