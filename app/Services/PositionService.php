<?php

namespace App\Services;

use App\Domain\Repositories\Position\PositionRepositoryInterface;

class PositionService
{
    protected PositionRepositoryInterface $positionRepository;
    public function __construct(PositionRepositoryInterface $positionRepository)
    {
        $this->positionRepository   =   $positionRepository;
    }

    public function list()
    {
        return $this->positionRepository->list();
    }

}
