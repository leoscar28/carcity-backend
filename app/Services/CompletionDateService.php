<?php

namespace App\Services;

use App\Domain\Repositories\CompletionDate\CompletionDateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompletionDateService
{
    protected CompletionDateRepositoryInterface $completionDateRepository;
    public function __construct(CompletionDateRepositoryInterface $completionDateRepository)
    {
        $this->completionDateRepository =   $completionDateRepository;
    }

    public function update($id,$data): ?object
    {
        return $this->completionDateRepository->update($id,$data);
    }

    public function getByRid($rid): ?object
    {
        return $this->completionDateRepository->getByRid($rid);
    }

    public function getById($id): ?object
    {
        return $this->completionDateRepository->getById($id);
    }

    public function pagination($data)
    {
        return $this->completionDateRepository->pagination($data);
    }

    public function list($data): Collection|array
    {
        return $this->completionDateRepository->list($data);
    }

    public function create($data): ?object
    {
        return $this->completionDateRepository->create($data);
    }

    public function delete($rid)
    {
        $this->completionDateRepository->delete($rid);
    }
}
