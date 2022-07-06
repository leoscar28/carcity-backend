<?php


namespace App\Services;


use App\Domain\Repositories\UserReview\UserReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserReviewService
{
    protected UserReviewRepositoryInterface $userReviewRepository;

    public function __construct(UserReviewRepositoryInterface $userReviewRepository)
    {
        $this->userReviewRepository = $userReviewRepository;
    }

    public function create($data)
    {
        return $this->userReviewRepository->create($data);
    }

    public function pagination($data)
    {
        return $this->userReviewRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->userReviewRepository->all($data);
    }

    public function getById($id)
    {
        return $this->userReviewRepository->getById($id);
    }

    public function delete($id, $data)
    {
        $this->userReviewRepository->delete($id, $data);
    }

}
