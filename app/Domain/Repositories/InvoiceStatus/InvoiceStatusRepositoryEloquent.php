<?php

namespace App\Domain\Repositories\InvoiceStatus;

use App\Domain\Contracts\MainContract;
use App\Models\InvoiceStatus;

class InvoiceStatusRepositoryEloquent implements InvoiceStatusRepositoryInterface
{
    public function list()
    {
        return InvoiceStatus::where(MainContract::STATUS,1)->get();
    }
}
