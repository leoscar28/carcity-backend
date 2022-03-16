<?php

namespace App\Services;

use App\Domain\Repositories\Role\RoleRepositoryInterface;

class RoleService
{
    protected RoleRepositoryInterface $roleRepository;
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository   =   $roleRepository;
    }

    public function list()
    {
        return $this->roleRepository->list();
    }

}
