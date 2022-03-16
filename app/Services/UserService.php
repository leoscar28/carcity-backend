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

    public function getByPhoneOrEmailOrAlias($login)
    {
        return $this->userRepository->getByPhoneOrEmailOrAlias($login);
    }

    public function getByToken($token)
    {
        return $this->userRepository->getByToken($token);
    }
}
