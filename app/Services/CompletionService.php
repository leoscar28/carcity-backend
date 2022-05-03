<?php

namespace App\Services;

use App\Domain\Repositories\Completion\CompletionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompletionService
{
    protected CompletionRepositoryInterface $completionRepository;
    public function __construct(CompletionRepositoryInterface $completionRepository)
    {
        $this->completionRepository =   $completionRepository;
    }

    public function list($rid)
    {
        return $this->completionRepository->list($rid);
    }

    public function create($data)
    {
        return $this->completionRepository->create($data);
    }

    public function pagination($data)
    {
        return $this->completionRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->completionRepository->all($data);
    }

    public function update($id,$data)
    {
        return $this->completionRepository->update($id,$data);
    }

    public function getById($id)
    {
        return $this->completionRepository->getById($id);
    }

    public function getByRidAndUploadStatusId($rid,$uploadStatusId)
    {
        return $this->completionRepository->getByRidAndUploadStatusId($rid,$uploadStatusId);
    }

    public function getByRid($rid)
    {
        return $this->completionRepository->getByRid($rid);
    }

    public function getByCustomerId($customerId)
    {
        return $this->completionRepository->getByCustomerId($customerId);
    }

    public function delete($rid)
    {
        $this->completionRepository->delete($rid);
    }

}
