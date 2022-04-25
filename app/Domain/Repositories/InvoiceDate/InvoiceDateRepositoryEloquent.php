<?php

namespace App\Domain\Repositories\InvoiceDate;

use App\Domain\Contracts\MainContract;
use App\Models\InvoiceDate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class InvoiceDateRepositoryEloquent implements InvoiceDateRepositoryInterface
{
    public function getByRid($rid): object|null
    {
        return InvoiceDate::without(MainContract::INVOICE, MainContract::INVOICE_STATUS)
            ->where([
                [MainContract::RID,$rid],
                [MainContract::STATUS,1]
            ])->first();
    }

    public function update($id,$data): ?object
    {
        InvoiceDate::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function pagination($data)
    {
        $query  =   InvoiceDate::select(DB::raw("(count(id)) as data"));
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        return $query->first();
    }

    public function list($data): Collection|array
    {
        $query  =   InvoiceDate::without(MainContract::INVOICE,MainContract::INVOICE_STATUS);
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::ID,'DESC');
        return $query->get();
    }

    public function get($data)
    {
        $query  =   InvoiceDate::without(MainContract::INVOICE,MainContract::INVOICE_STATUS);
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::ID,'DESC');
        return $query->get();
    }

    public function create($data): ?object
    {
        $invoice    =   InvoiceDate::create($data);
        return $this->getById($invoice->{MainContract::ID});
    }

    public function getById($id): object|null
    {
        return InvoiceDate::without(MainContract::INVOICE, MainContract::INVOICE_STATUS)
            ->where([
                [MainContract::ID,$id],
                [MainContract::STATUS,1]
            ])->first();
    }

    public function delete($rid)
    {
        InvoiceDate::where(MainContract::RID,$rid)->update([
            MainContract::STATUS    =>  0
        ]);
    }

}
