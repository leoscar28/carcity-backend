<?php

namespace App\Services;

use App\Domain\Repositories\ApplicationStatus\ApplicationStatusRepositoryInterface;

class ApplicationStatusService
{
    protected ApplicationStatusRepositoryInterface $applicationStatusRepository;
    public function __construct(ApplicationStatusRepositoryInterface $applicationStatusRepository)
    {
        $this->applicationStatusRepository  =   $applicationStatusRepository;
    }

    public function list()
    {
        return $this->applicationStatusRepository->list();
    }
}
