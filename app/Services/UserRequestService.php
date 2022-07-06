<?php


namespace App\Services;


use App\Domain\Repositories\UserRequest\UserRequestRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRequestService
{
    protected UserRequestRepositoryInterface $userRequestRepository;

    public function __construct(UserRequestRepositoryInterface $userRequestRepository)
    {
        $this->userRequestRepository = $userRequestRepository;
    }

    public function create($data)
    {
        return $this->userRequestRepository->create($data);
    }

    public function pagination($data)
    {
        return $this->userRequestRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->userRequestRepository->all($data);
    }

    public function getById($id)
    {
        return $this->userRequestRepository->getById($id);
    }

    public function unpublish($id)
    {
        $this->userRequestRepository->unpublish($id);
    }
}
