<?php

namespace App\Services;

use App\Domain\Repositories\Application\ApplicationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\ArrayShape;

class ApplicationService
{
    protected ApplicationRepositoryInterface $applicationRepository;

    public function __construct(ApplicationRepositoryInterface $applicationRepository)
    {
        $this->applicationRepository    =   $applicationRepository;
    }

    #[ArrayShape(['data' => "int"])] public function paginationByCustomerAndNumber($data): array
    {
        return $this->applicationRepository->paginationByCustomerAndNumber($data);
    }

    public function getByCustomerAndNumber($data): Collection|array
    {
        return $this->applicationRepository->getByCustomerAndNumber($data);
    }

    public function getByRidAndCompany($rid, $company): Collection|array
    {
        return $this->applicationRepository->getByRidAndCompany($rid, $company);
    }

    public function list($rid)
    {
        return $this->applicationRepository->list($rid);
    }

    public function create($data)
    {
        return $this->applicationRepository->create($data);
    }

    public function pagination($data)
    {
        return $this->applicationRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->applicationRepository->all($data);
    }

    public function get($data)
    {
        return $this->applicationRepository->get($data);
    }

    public function update($id,$data)
    {
        return $this->applicationRepository->update($id,$data);
    }

    public function getById($id)
    {
        return $this->applicationRepository->getById($id);
    }

    public function getByRidAndUploadStatusId($rid,$uploadStatusId)
    {
        return $this->applicationRepository->getByRidAndUploadStatusId($rid,$uploadStatusId);
    }

    public function getByRid($rid)
    {
        return $this->applicationRepository->getByRid($rid);
    }

    public function getByCustomerId($customerId)
    {
        return $this->applicationRepository->getByCustomerId($customerId);
    }

    public function delete($rid)
    {
        $this->applicationRepository->delete($rid);
    }

}
