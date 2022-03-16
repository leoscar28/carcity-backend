<?php

namespace App\Services;

use App\Domain\Repositories\UploadStatus\UploadStatusRepositoryInterface;

class UploadStatusService
{
    protected UploadStatusRepositoryInterface $uploadStatusRepository;
    public function __construct(UploadStatusRepositoryInterface $uploadStatusRepository)
    {
        $this->uploadStatusRepository   =   $uploadStatusRepository;
    }

    public function list()
    {
        return $this->uploadStatusRepository->list();
    }

}
