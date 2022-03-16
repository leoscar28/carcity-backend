<?php

namespace App\Domain\Repositories\Invoice;

use App\Domain\Contracts\MainContract;
use App\Models\Invoice;

class InvoiceRepositoryEloquent implements InvoiceRepositoryInterface
{
    public function create($data)
    {
        $invoice    =   Invoice::create($data);
        return $this->getById($invoice->{MainContract::ID});
    }

    public function update($id,$data)
    {
        Invoice::where(MainContract::ID,$id)
            ->update($data);
        return $this->getById($id);
    }

    public function getById($id)
    {
        return Invoice::with(MainContract::INVOICE_LIST)
            ->where(MainContract::ID,$id)->first();
    }

}
