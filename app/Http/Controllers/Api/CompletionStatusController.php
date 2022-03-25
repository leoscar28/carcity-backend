<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompletionStatus\CompletionStatusCollection;
use App\Services\CompletionStatusService;
use Illuminate\Http\Request;

class CompletionStatusController extends Controller
{
    protected CompletionStatusService $completionStatusService;
    public function __construct(CompletionStatusService $completionStatusService)
    {
        $this->completionStatusService  =   $completionStatusService;
    }

    public function list(): CompletionStatusCollection
    {
        return new CompletionStatusCollection($this->completionStatusService->list());
    }
}
