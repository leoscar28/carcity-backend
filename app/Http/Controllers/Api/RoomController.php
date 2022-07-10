<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Room\RoomCollection;
use App\Services\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected RoomService $roomService;
    public function __construct(RoomService $roomService)
    {
        $this->roomService  =   $roomService;
    }

    public function getByUserId($userId): RoomCollection
    {
        return new RoomCollection($this->roomService->getByUserId($userId));
    }

    public function get(): RoomCollection
    {
        return new RoomCollection($this->roomService->get());
    }

}
