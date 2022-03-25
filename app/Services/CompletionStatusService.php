<?php

namespace App\Services;

use App\Domain\Repositories\CompletionStatus\CompletionStatusRepositoryInterface;

class CompletionStatusService
{
    protected CompletionStatusRepositoryInterface $completionStatusRepository;
    public function __construct(CompletionStatusRepositoryInterface $completionStatusRepository)
    {
        $this->completionStatusRepository   =   $completionStatusRepository;
    }

    public function list()
    {
        return $this->completionStatusRepository->list();
    }
}
