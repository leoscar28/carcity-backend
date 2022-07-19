<?php

namespace App\Services;

use App\Domain\Repositories\Awards\AwardsRepositoryInterface;

class AwardsService
{
    protected AwardsRepositoryInterface $awardsRepository;
    public function __construct(AwardsRepositoryInterface $awardsRepository)
    {
        $this->awardsRepository =   $awardsRepository;
    }

    public function get()
    {
        return $this->awardsRepository->get();
    }

}
