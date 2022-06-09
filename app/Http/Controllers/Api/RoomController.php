<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected RoomService $roomService;
    public function __construct(RoomService $roomService)
    {
        $this->roomService  =   $roomService;
    }
}
