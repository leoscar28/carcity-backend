<?php

namespace App\Services;

use App\Domain\Repositories\InvoiceList\InvoiceListRepositoryInterface;

class InvoiceListService
{
    protected InvoiceListRepositoryInterface $invoiceListRepository;
    public function __construct(InvoiceListRepositoryInterface $invoiceListRepository)
    {
        $this->invoiceListRepository    =   $invoiceListRepository;
    }

    public function create($data)
    {
        return $this->invoiceListRepository->create($data);
    }

}
