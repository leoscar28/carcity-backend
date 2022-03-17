<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ApplicationCreateRequest;
use App\Http\Requests\Application\ApplicationUpdateRequest;
use App\Http\Resources\Application\ApplicationResource;
use App\Services\ApplicationService;
use App\Services\ApplicationListService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
    protected ApplicationService $applicationService;
    protected ApplicationListService $applicationListService;
    public function __construct(ApplicationService $applicationService,ApplicationListService $applicationListService)
    {
        $this->applicationService   =   $applicationService;
        $this->applicationListService   =   $applicationListService;
    }

    /**
     * @throws ValidationException
     */
    public function create(ApplicationCreateRequest $applicationCreateRequest): ApplicationResource
    {
        $data   =   $applicationCreateRequest->check();
        $application    =   $this->applicationService->create([
            MainContract::UPLOAD_STATUS_ID  =>  1,
            MainContract::DOCUMENT_ALL  =>  sizeof($data),
        ]);

        foreach ($data as &$applicationItem) {
            $this->applicationListService->create([
                MainContract::APPLICATION_ID    =>  $application->{MainContract::ID},
                MainContract::CUSTOMER  =>  $applicationItem[MainContract::CUSTOMER]??NULL,
                MainContract::CUSTOMER_ID   =>  $applicationItem[MainContract::CUSTOMER_ID]??NULL,
                MainContract::NUMBER    =>  $applicationItem[MainContract::NUMBER]??NULL,
                MainContract::ORGANIZATION  =>  $applicationItem[MainContract::ORGANIZATION]??NULL,
                MainContract::DATE  =>  $applicationItem[MainContract::DATE]??NULL,
                MainContract::SUM   =>  $applicationItem[MainContract::SUM]??NULL,
                MainContract::NAME  =>  $applicationItem[MainContract::NAME]??NULL,
            ]);
        }
        return new ApplicationResource($this->applicationService->getById($application->{MainContract::ID}));
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
