<?php

namespace App\Services;

use App\Domain\Repositories\CompletionSignature\CompletionSignatureRepositoryInterface;

class CompletionSignatureService
{
    protected CompletionSignatureRepositoryInterface $completionSignatureRepository;
    public function __construct(CompletionSignatureRepositoryInterface $completionSignatureRepository)
    {
        $this->completionSignatureRepository    =   $completionSignatureRepository;
    }

    public function create($data)
    {
        return $this->completionSignatureRepository->create($data);
    }

    public function update($id,$data)
    {
        return $this->completionSignatureRepository->update($id,$data);
    }

    public function getByCompletionIdAndUserId($completionId,$userId)
    {
        return $this->completionSignatureRepository->getByCompletionIdAndUserId($completionId,$userId);
    }

    public function getByCompletionId($id)
    {
        return $this->completionSignatureRepository->getByCompletionId($id);
    }
}
