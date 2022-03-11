<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ApplicationCreateRequest;
use App\Http\Requests\Application\ApplicationUpdateRequest;
use App\Http\Resources\Application\ApplicationResource;
use App\Services\ApplicationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
    protected ApplicationService $applicationService;
    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService   =   $applicationService;
    }

    /**
     * @throws ValidationException
     */
    public function create(ApplicationCreateRequest $applicationCreateRequest): ApplicationResource
    {
        return new ApplicationResource($this->applicationService->create($applicationCreateRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, ApplicationUpdateRequest $applicationUpdateRequest): Response|ApplicationResource|Application|ResponseFactory
    {
        if ($application = $this->applicationService->update($id,$applicationUpdateRequest->check())) {
            return new ApplicationResource($application);
        }
        return response(['message'  =>  'Application not found'],404);
    }

    public function getById($id): Response|ApplicationResource|Application|ResponseFactory
    {
        if ($application = $this->applicationService->getById($id)) {
            return new ApplicationResource($application);
        }
        return response(['message'  =>  'Application not found'],404);
    }


}
