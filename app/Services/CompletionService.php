<?php

namespace App\Services;

use App\Domain\Repositories\Completion\CompletionRepositoryInterface;

class CompletionService
{
    protected CompletionRepositoryInterface $completionRepository;
    public function __construct(CompletionRepositoryInterface $completionRepository)
    {
        $this->completionRepository =   $completionRepository;
    }

    public function create($data)
    {
        return $this->completionRepository->create($data);
    }

    public function update($id,$data)
    {
        return $this->completionRepository->update($id,$data);
    }

    public function getById($id)
    {
        return $this->completionRepository->getById($id);
    }

}
