<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\UserReviewContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserReview\UserReviewAddCommentRequest;
use App\Http\Requests\UserReview\UserReviewCreateRequest;
use App\Http\Requests\UserReview\UserReviewListRequest;
use App\Http\Resources\UserReview\UserReviewCollection;
use App\Http\Resources\UserReview\UserReviewResource;
use App\Services\UserReviewService;
use Illuminate\Validation\ValidationException;

class UserReviewController extends Controller
{
    protected UserReviewService $userReviewService;
    public function __construct(UserReviewService $userReviewService)
    {
        $this->userReviewService   =   $userReviewService;
    }

    /**
     * @param UserReviewCreateRequest $userBannerCreateRequest
//     * @return UserReviewResource
     * @throws ValidationException
     */
    public function create(UserReviewCreateRequest $userBannerCreateRequest)
    {
        $data = $userBannerCreateRequest->check();

        $userBanner = $this->userReviewService->create($data);

        return new UserReviewResource($userBanner);
    }

    /* @param UserReviewListRequest $userBannerListRequest
    * @return mixed
    * @throws ValidationException
    */
    public function pagination(UserReviewListRequest $userBannerListRequest)
    {
        return $this->userReviewService->pagination($userBannerListRequest->check());
    }

    /**
     * @param UserReviewListRequest $userBannerListRequest
     * @return UserReviewCollection
     * @throws ValidationException
     */
    public function all(UserReviewListRequest $userBannerListRequest): UserReviewCollection
    {
        return new UserReviewCollection($this->userReviewService->all($userBannerListRequest->check()));
    }

    public function delete($id, UserReviewAddCommentRequest $request)
    {
        $this->userReviewService->delete($id, $request->check());
    }
}
