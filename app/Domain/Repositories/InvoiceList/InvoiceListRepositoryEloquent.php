<?php

namespace App\Domain\Repositories\InvoiceList;

use App\Models\InvoiceList;

class InvoiceListRepositoryEloquent implements InvoiceListRepositoryInterface
{
    public function create($data)
    {
        return InvoiceList::create($data);
    }
}
