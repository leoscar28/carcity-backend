<?php

namespace App\Services;

use App\Domain\Repositories\InfrastructureOption\InfrastructureOptionRepositoryInterface;

class InfrastructureOptionService
{
    protected InfrastructureOptionRepositoryInterface $infrastructureOptionRepository;
    public function __construct(InfrastructureOptionRepositoryInterface $infrastructureOptionRepository)
    {
        $this->infrastructureOptionRepository   =   $infrastructureOptionRepository;
    }

    public function get()
    {
        return $this->infrastructureOptionRepository->get();
    }

}
