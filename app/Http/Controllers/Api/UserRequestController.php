<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\UserRequestCreateRequest;
use App\Http\Requests\UserRequest\UserRequestListRequest;
use App\Http\Resources\UserRequest\UserRequestCollection;
use App\Http\Resources\UserRequest\UserRequestResource;
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
     * @param UserRequestCreateRequest $userBannerCreateRequest
     * @return UserRequestResource
     * @throws ValidationException
     */
    public function create(UserRequestCreateRequest $userBannerCreateRequest)
    {
        $data = $userBannerCreateRequest->check();

        $userBanner = $this->userRequestService->create($data);

        return new UserRequestResource($userBanner);
    }

    /* @param UserRequestListRequest $userBannerListRequest
     * @return mixed
     * @throws ValidationException
     */
    public function pagination(UserRequestListRequest $userBannerListRequest)
    {
        return $this->userRequestService->pagination($userBannerListRequest->check());
    }

    /**
     * @param UserRequestListRequest $userBannerListRequest
     * @return UserRequestCollection
     * @throws ValidationException
     */
    public function all(UserRequestListRequest $userBannerListRequest): UserRequestCollection
    {
        return new UserRequestCollection($this->userRequestService->all($userBannerListRequest->check()));
    }

    public function unpublish($id)
    {
        $this->userRequestService->unpublish($id);
    }
}
