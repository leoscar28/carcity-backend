<?php

namespace App\Services;

use App\Domain\Repositories\Invoice\InvoiceRepositoryInterface;

class InvoiceService
{
    protected InvoiceRepositoryInterface $invoiceRepository;
    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository    =   $invoiceRepository;
    }

    public function list($rid)
    {
        return $this->invoiceRepository->list($rid);
    }

    public function create($data)
    {
        return $this->invoiceRepository->create($data);
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

}
