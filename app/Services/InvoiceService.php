<?php

namespace App\Services;

use App\Domain\Repositories\Invoice\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\ArrayShape;

class InvoiceService
{
    protected InvoiceRepositoryInterface $invoiceRepository;
    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository    =   $invoiceRepository;
    }

    #[ArrayShape(['data' => "int"])] public function paginationByCustomerAndNumber($data): array
    {
        return $this->invoiceRepository->paginationByCustomerAndNumber($data);
    }

    public function getByCustomerAndNumber($data): Collection|array
    {
        return $this->invoiceRepository->getByCustomerAndNumber($data);
    }

    public function list($rid)
    {
        return $this->invoiceRepository->list($rid);
    }

    public function create($data)
    {
        return $this->invoiceRepository->create($data);
    }

    public function pagination($data)
    {
        return $this->invoiceRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->invoiceRepository->all($data);
    }

    public function update($id,$data)
    {
        return $this->invoiceRepository->update($id,$data);
    }

    public function getById($id)
    {
        return $this->invoiceRepository->getById($id);
    }

    public function getByRid($rid)
    {
        return $this->invoiceRepository->getByRid($rid);
    }

    public function getByCustomerId($customerId)
    {
        return $this->invoiceRepository->getByCustomerId($customerId);
    }

    public function delete($rid)
    {
        $this->invoiceRepository->delete($rid);
    }

}
