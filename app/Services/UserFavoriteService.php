<?php


namespace App\Services;


use App\Domain\Repositories\UserFavorite\UserFavoriteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserFavoriteService
{
    protected UserFavoriteRepositoryInterface $userFavoriteRepository;

    public function __construct(UserFavoriteRepositoryInterface $userFavoriteRepository)
    {
        $this->userFavoriteRepository = $userFavoriteRepository;
    }

    public function create($data)
    {
        return $this->userFavoriteRepository->create($data);
    }

    public function pagination($data)
    {
        return $this->userFavoriteRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->userFavoriteRepository->all($data);
    }

    public function getById($id)
    {
        return $this->userFavoriteRepository->getById($id);
    }

    public function add($data)
    {
        $this->userFavoriteRepository->add($data);
    }

    public function remove($data)
    {
        $this->userFavoriteRepository->remove($data);
    }

}
