<?php

namespace App\Services;

use App\Domain\Repositories\Tier\TierRepositoryInterface;

class TierService
{
    protected TierRepositoryInterface $tierRepository;
    public function __construct(TierRepositoryInterface $tierRepository)
    {
        $this->tierRepository   =   $tierRepository;
    }

    public function get()
    {
        return $this->tierRepository->get();
    }

}
