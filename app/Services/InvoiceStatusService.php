<?php

namespace App\Services;

use App\Domain\Repositories\InvoiceStatus\InvoiceStatusRepositoryInterface;

class InvoiceStatusService
{
    protected InvoiceStatusRepositoryInterface $invoiceStatusRepository;
    public function __construct(InvoiceStatusRepositoryInterface $invoiceStatusRepository)
    {
        $this->invoiceStatusRepository  =   $invoiceStatusRepository;
    }

    public function list()
    {
        return $this->invoiceStatusRepository->list();
    }

}
