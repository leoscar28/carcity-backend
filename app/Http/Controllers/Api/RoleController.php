<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Role\RoleCollection;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected RoleService $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService  =   $roleService;
    }

    public function list(): RoleCollection
    {
        return new RoleCollection($this->roleService->list());
    }

}
