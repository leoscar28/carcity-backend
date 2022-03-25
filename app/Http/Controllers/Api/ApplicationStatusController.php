<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationStatus\ApplicationStatusCollection;
use App\Models\ApplicationStatus;
use App\Services\ApplicationStatusService;
use Illuminate\Http\Request;

class ApplicationStatusController extends Controller
{
    protected ApplicationStatusService $applicationStatusService;
    public function __construct(ApplicationStatusService $applicationStatusService)
    {
        $this->applicationStatusService =   $applicationStatusService;
    }

    public function list(): ApplicationStatusCollection
    {
        return new ApplicationStatusCollection($this->applicationStatusService->list());
    }
}
