<?php

namespace App\Services;

use App\Domain\Repositories\User\UserRepositoryInterface;

class UserService
{
    protected UserRepositoryInterface $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository   =   $userRepository;
    }

    public function getByPhoneOrEmailOrAlias($login): ?object
    {
        return $this->userRepository->getByPhoneOrEmailOrAlias($login);
    }

    public function update($id,$data): ?object
    {
        return $this->userRepository->update($id,$data);
    }

    public function getByPhone($phone): ?object
    {
        return $this->userRepository->getByPhone($phone);
    }

    public function getByToken($token): ?object
    {
        return $this->userRepository->getByToken($token);
    }

    public function getById($id): ?object
    {
        return $this->userRepository->getById($id);
    }

    public function getByRoleIds($ids)
    {
        return $this->userRepository->getByRoleIds($ids);
    }

    public function getByBin($bin)
    {
        return $this->userRepository->getByBin($bin);
    }
}
