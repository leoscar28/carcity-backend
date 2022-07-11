<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\UserReviewContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserReview\UserReviewAddCommentRequest;
use App\Http\Requests\UserReview\UserReviewCreateRequest;
use App\Http\Requests\UserReview\UserReviewListRequest;
use App\Http\Resources\UserReview\UserReviewCollection;
use App\Http\Resources\UserReview\UserReviewResource;
use App\Jobs\UserReviewJob;
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
     * @param UserReviewCreateRequest $userReviewCreateRequest
//     * @return UserReviewResource
     * @throws ValidationException
     */
    public function create(UserReviewCreateRequest $userReviewCreateRequest)
    {
        $data = $userReviewCreateRequest->check();

        $userReview = $this->userReviewService->create($data);
        UserReviewJob::dispatch($userReview);

        return new UserReviewResource($userReview);
    }

    /* @param UserReviewListRequest $userReviewListRequest
    * @return mixed
    * @throws ValidationException
    */
    public function pagination(UserReviewListRequest $userReviewListRequest)
    {
        return $this->userReviewService->pagination($userReviewListRequest->check());
    }

    /**
     * @param UserReviewListRequest $userReviewListRequest
     * @return UserReviewCollection
     * @throws ValidationException
     */
    public function all(UserReviewListRequest $userReviewListRequest): UserReviewCollection
    {
        return new UserReviewCollection($this->userReviewService->all($userReviewListRequest->check()));
    }

    public function delete($id, UserReviewAddCommentRequest $request)
    {
        $this->userReviewService->delete($id, $request->check());

        UserReviewJob::dispatch($this->userReviewService->getById($id), 2);
    }
}
