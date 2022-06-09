<?php

namespace App\Services;

use App\Domain\Repositories\RoomType\RoomTypeRepositoryInterface;

class RoomTypeService
{
    protected RoomTypeRepositoryInterface $roomTypeRepository;
    public function __construct(RoomTypeRepositoryInterface $roomTypeRepository)
    {
        $this->roomTypeRepository   =   $roomTypeRepository;
    }
}
