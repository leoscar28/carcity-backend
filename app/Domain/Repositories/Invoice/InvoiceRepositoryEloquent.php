<?php

namespace App\Domain\Repositories\Invoice;

use App\Domain\Contracts\MainContract;
use App\Models\Invoice;

class InvoiceRepositoryEloquent implements InvoiceRepositoryInterface
{
    public function create($data)
    {
        return Invoice::create($data);
    }

    public function update($id,$data)
    {
        Invoice::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getById($id)
    {
        return Invoice::where([
            [MainContract::ID,$id],
            [MainContract::STATUS,MainContract::TRUE]
        ])->first();
    }

}
