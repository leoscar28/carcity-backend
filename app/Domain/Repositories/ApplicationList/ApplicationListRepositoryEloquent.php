<?php

namespace App\Domain\Repositories\ApplicationList;

use App\Models\ApplicationList;

class ApplicationListRepositoryEloquent implements ApplicationListRepositoryInterface
{
    public function create($data)
    {
        return ApplicationList::create($data);
    }
}
