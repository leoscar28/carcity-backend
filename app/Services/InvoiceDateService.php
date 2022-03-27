<?php

namespace App\Services;

use App\Domain\Repositories\InvoiceDate\InvoiceDateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class InvoiceDateService
{
    protected InvoiceDateRepositoryInterface $invoiceDateRepository;
    public function __construct(InvoiceDateRepositoryInterface $invoiceDateRepository)
    {
        $this->invoiceDateRepository    =   $invoiceDateRepository;
    }

    public function getByRid($rid): ?object
    {
        return $this->invoiceDateRepository->getByRid($rid);
    }

    public function update($id,$data): ?object
    {
        return $this->invoiceDateRepository->update($id,$data);
    }

    public function pagination($data)
    {
        return $this->invoiceDateRepository->pagination($data);
    }

    public function list($data): Collection|array
    {
        return $this->invoiceDateRepository->list($data);
    }

    public function create($data): ?object
    {
        return $this->invoiceDateRepository->create($data);
    }

    public function getById($id): ?object
    {
        return $this->invoiceDateRepository->getById($id);
    }

    public function delete($rid)
    {
        $this->invoiceDateRepository->delete($rid);
    }

}
