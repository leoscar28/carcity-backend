<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserBinService;
use Illuminate\Http\Request;

class UserBinController extends Controller
{
    protected UserBinService $userBinService;
    public function __construct(UserBinService $userBinService)
    {
        $this->userBinService   =   $userBinService;
    }
}
