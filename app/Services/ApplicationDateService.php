<?php

namespace App\Services;

use App\Domain\Repositories\ApplicationDate\ApplicationDateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ApplicationDateService
{
    protected ApplicationDateRepositoryInterface $applicationDateRepository;
    protected ApplicationService $applicationService;
    public function __construct(ApplicationDateRepositoryInterface $applicationDateRepository, ApplicationService $applicationService)
    {
        $this->applicationDateRepository    =   $applicationDateRepository;
        $this->applicationService   =   $applicationService;
    }

    public function getByRid($rid): ?object
    {
        return $this->applicationDateRepository->getByRid($rid);
    }

    public function pagination($data)
    {
        return $this->applicationDateRepository->pagination($data);
    }

    public function list($data): Collection|array
    {
        return $this->applicationDateRepository->list($data);
    }

    public function update($id,$data): ?object
    {
        return $this->applicationDateRepository->update($id,$data);
    }

    public function getById($id): ?object
    {
        return $this->applicationDateRepository->getById($id);
    }

    public function create($data): ?object
    {
        return $this->applicationDateRepository->create($data);
    }

    public function delete($rid)
    {
        $this->applicationDateRepository->delete($rid);
        $this->applicationService->delete($rid);
    }

}
