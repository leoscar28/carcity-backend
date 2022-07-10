<?php

namespace App\Services;

use App\Domain\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoomService
{
    protected RoomRepositoryInterface $roomRepository;
    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        $this->roomRepository   =   $roomRepository;
    }

    public function getByUserId($userId): Collection|array
    {
        return $this->roomRepository->getByUserId($userId);
    }

    public function get(): Collection|array
    {
        return $this->roomRepository->get();
    }

}
