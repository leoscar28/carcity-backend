<?php

namespace App\Services;

use App\Domain\Repositories\ApplicationSignature\ApplicationSignatureRepositoryInterface;

class ApplicationSignatureService
{
    protected ApplicationSignatureRepositoryInterface $applicationSignatureRepository;
    public function __construct(ApplicationSignatureRepositoryInterface $applicationSignatureRepository)
    {
        $this->applicationSignatureRepository   =   $applicationSignatureRepository;
    }

    public function create($data)
    {
        return $this->applicationSignatureRepository->create($data);
    }

    public function getByApplicationIdAndUserId($applicationId,$userId)
    {
        return $this->applicationSignatureRepository->getByApplicationIdAndUserId($applicationId,$userId);
    }

    public function existsByApplicationIdAndUserId($applicationId,$userId)
    {
        return $this->applicationSignatureRepository->existsByApplicationIdAndUserId($applicationId,$userId);
    }

    public function update($id,$data)
    {
        return $this->applicationSignatureRepository->update($id,$data);
    }

    public function getByApplicationId($id)
    {
        return $this->applicationSignatureRepository->getByApplicationId($id);
    }
}
