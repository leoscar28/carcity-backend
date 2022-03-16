<?php

namespace App\Services;

use App\Domain\Repositories\CompletionList\CompletionListRepositoryInterface;

class CompletionListService
{
    protected CompletionListRepositoryInterface $completionListRepository;
    public function __construct(CompletionListRepositoryInterface $completionListRepository)
    {
        $this->completionListRepository =   $completionListRepository;
    }

    public function create($data)
    {
        return $this->completionListRepository->create($data);
    }

}
