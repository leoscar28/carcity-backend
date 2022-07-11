<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\UserRequestCreateRequest;
use App\Http\Requests\UserRequest\UserRequestListRequest;
use App\Http\Resources\UserRequest\UserRequestCollection;
use App\Http\Resources\UserRequest\UserRequestResource;
use App\Jobs\UserRequestJob;
use App\Services\UserRequestService;
use Illuminate\Validation\ValidationException;

class UserRequestController extends Controller
{
    protected UserRequestService $userRequestService;
    public function __construct(UserRequestService $userRequestService)
    {
        $this->userRequestService   =   $userRequestService;
    }

    /**
     * @param UserRequestCreateRequest $userRequestCreateRequest
     * @return UserRequestResource
     * @throws ValidationException
     */
    public function create(UserRequestCreateRequest $userRequestCreateRequest)
    {
        $data = $userRequestCreateRequest->check();

        $userRequest = $this->userRequestService->create($data);

        UserRequestJob::dispatch($userRequest);

        return new UserRequestResource($userRequest);
    }

    /* @param UserRequestListRequest $userRequestListRequest
     * @return mixed
     * @throws ValidationException
     */
    public function pagination(UserRequestListRequest $userRequestListRequest)
    {
        return $this->userRequestService->pagination($userRequestListRequest->check());
    }

    /**
     * @param UserRequestListRequest $userRequestListRequest
     * @return UserRequestCollection
     * @throws ValidationException
     */
    public function all(UserRequestListRequest $userRequestListRequest): UserRequestCollection
    {
        return new UserRequestCollection($this->userRequestService->all($userRequestListRequest->check()));
    }

    public function unpublish($id)
    {
        $this->userRequestService->unpublish($id);
        UserRequestJob::dispatch($this->userRequestService->getById($id), 2);
    }
}
