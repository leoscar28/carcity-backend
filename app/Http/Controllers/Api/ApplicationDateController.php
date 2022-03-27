<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationDate\ApplicationDateListRequest;
use App\Http\Requests\ApplicationDate\ApplicationDateUpdateRequest;
use App\Http\Resources\ApplicationDate\ApplicationDateCollection;
use App\Http\Resources\ApplicationDate\ApplicationDateResource;
use App\Models\ApplicationDate;
use App\Services\ApplicationDateService;
use App\Services\ApplicationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApplicationDateController extends Controller
{
    protected ApplicationDateService $applicationDateService;
    protected ApplicationService $applicationService;
    public function __construct(ApplicationDateService $applicationDateService, ApplicationService $applicationService)
    {
        $this->applicationDateService   =   $applicationDateService;
        $this->applicationService   =   $applicationService;
    }

    /**
     * @throws ValidationException
     */
    public function pagination(ApplicationDateListRequest $applicationDateListRequest)
    {
        return $this->applicationDateService->pagination($applicationDateListRequest->check());
    }

    /**
     * @throws ValidationException
     */
    public function list(ApplicationDateListRequest $applicationDateListRequest): ApplicationDateCollection
    {
        return new ApplicationDateCollection($this->applicationDateService->list($applicationDateListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, ApplicationDateUpdateRequest $applicationDateUpdateRequest): ApplicationDateResource|Response|Application|ResponseFactory
    {
        if ($applicationDate = $this->applicationDateService->update($id,$applicationDateUpdateRequest->check())) {
            return new ApplicationDateResource($applicationDate);
        }
        return response(['message'  =>  'ApplicationDate not found'],404);
    }

    public function getByRid($rid): ApplicationDateResource|Response|Application|ResponseFactory
    {
        if ($applicationDate = $this->applicationDateService->getByRid($rid)) {
            return new ApplicationDateResource($applicationDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function getById($id): ApplicationDateResource|Response|Application|ResponseFactory
    {
        if ($applicationDate = $this->applicationDateService->getById($id)) {
            return new ApplicationDateResource($applicationDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function delete($rid)
    {
        $this->applicationDateService->delete($rid);
        $this->applicationService->delete($rid);
    }

}
