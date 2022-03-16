<?php

namespace App\Domain\Repositories\UploadStatus;

use App\Domain\Contracts\MainContract;
use App\Models\UploadStatus;

class UploadStatusRepositoryEloquent implements UploadStatusRepositoryInterface
{
    public function list()
    {
        return UploadStatus::where(MainContract::STATUS,1)->get();
    }
}
