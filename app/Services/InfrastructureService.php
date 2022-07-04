<?php

namespace App\Services;

use App\Domain\Repositories\Infrastructure\InfrastructureRepositoryInterface;

class InfrastructureService
{
    protected InfrastructureRepositoryInterface $infrastructureRepository;
    public function __construct(InfrastructureRepositoryInterface $infrastructureRepository)
    {
        $this->infrastructureRepository =   $infrastructureRepository;
    }

    public function get()
    {
        return $this->infrastructureRepository->get();
    }

}
