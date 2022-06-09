<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RoomTypeService;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    protected RoomTypeService $roomTypeService;
    public function __construct(RoomTypeService $roomTypeService)
    {
        $this->roomTypeService  =   $roomTypeService;
    }
}
