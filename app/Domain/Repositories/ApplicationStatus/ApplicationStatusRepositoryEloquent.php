<?php

namespace App\Domain\Repositories\ApplicationStatus;

use App\Domain\Contracts\MainContract;
use App\Models\ApplicationStatus;

class ApplicationStatusRepositoryEloquent implements ApplicationStatusRepositoryInterface
{
    public function list()
    {
        return ApplicationStatus::where(MainContract::STATUS,1)->get();
    }
}
