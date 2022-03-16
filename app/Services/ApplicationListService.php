<?php

namespace App\Services;

use App\Domain\Repositories\ApplicationList\ApplicationListRepositoryInterface;

class ApplicationListService
{
    protected ApplicationListRepositoryInterface $applicationListRepository;
    public function __construct(ApplicationListRepositoryInterface $applicationListRepository)
    {
        $this->applicationListRepository    =   $applicationListRepository;
    }

    public function create($data)
    {
        return $this->applicationListRepository->create($data);
    }

}
