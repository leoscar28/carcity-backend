<?php

namespace App\Domain\Repositories\CompletionStatus;

use App\Domain\Contracts\MainContract;
use App\Models\CompletionStatus;

class CompletionStatusRepositoryEloquent implements CompletionStatusRepositoryInterface
{
    public function list()
    {
        return CompletionStatus::where(MainContract::STATUS,1)->get();
    }
}
