<?php

namespace App\Services;

use App\Domain\Repositories\UserBin\UserBinRepositoryInterface;

class UserBinService
{
    protected UserBinRepositoryInterface $userBinRepository;
    public function __construct(UserBinRepositoryInterface $userBinRepository)
    {
        $this->userBinRepository    =   $userBinRepository;
    }

    public function getByIin($bin)
    {
        return $this->userBinRepository->getByIin($bin);
    }

}
