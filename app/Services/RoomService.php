<?php

namespace App\Services;

use App\Domain\Repositories\Room\RoomRepositoryInterface;

class RoomService
{
    protected RoomRepositoryInterface $roomRepository;
    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        $this->roomRepository   =   $roomRepository;
    }

    public function getByUserId($userId)
    {
        return $this->roomRepository->getByUserId($userId);
    }

}
