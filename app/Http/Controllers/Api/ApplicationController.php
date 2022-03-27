<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ApplicationCreateRequest;
use App\Http\Requests\Application\ApplicationListRequest;
use App\Http\Requests\Application\ApplicationUpdateRequest;
use App\Http\Resources\Application\ApplicationCollection;
use App\Http\Resources\Application\ApplicationResource;
use App\Jobs\ApplicationCount;
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
    public function create(ApplicationCreateRequest $applicationCreateRequest): ApplicationCollection
    {
        $data   =   $applicationCreateRequest->check();
        $arr    =   [];
        foreach ($data[MainContract::DATA] as &$applicationItem) {
            $arr[]  =   $this->applicationService->create($applicationItem);
        }
        ApplicationCount::dispatch($data[MainContract::RID]);
        return new ApplicationCollection($arr);
    }

    /**
     * @throws ValidationException
     */
    public function pagination(ApplicationListRequest $completionListRequest)
    {
        return $this->applicationService->pagination($completionListRequest->check());
    }

    /**
     * @throws ValidationException
     */
    public function all(ApplicationListRequest $completionListRequest): ApplicationCollection
    {
        return new ApplicationCollection($this->applicationService->all($completionListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, ApplicationUpdateRequest $applicationUpdateRequest): Response|ApplicationResource|Application|ResponseFactory
    {
        if ($application = $this->applicationService->update($id,$applicationUpdateRequest->check())) {
            ApplicationCount::dispatch($application->{MainContract::RID});
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

    public function getByRid($rid): ApplicationCollection
    {
        return new ApplicationCollection($this->applicationService->getByRid($rid));
    }

    public function delete($rid,$id)
    {
        $this->applicationService->update($id,[
            MainContract::STATUS    =>  0
        ]);
        ApplicationCount::dispatch($rid);
    }

}
