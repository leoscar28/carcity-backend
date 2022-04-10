<?php

namespace App\Domain\Repositories\Invoice;

use App\Domain\Contracts\MainContract;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class InvoiceRepositoryEloquent implements InvoiceRepositoryInterface
{

    public function list($rid)
    {
        return Invoice::select(
            DB::raw("(min(invoices.upload_status_id)) as upload_status_id"),
            DB::raw("(count(invoices.id)) as document_all"),
            DB::raw("(DATE_FORMAT(invoices.created_at, '%d-%m-%Y')) as created_at"),
            DB::raw("COUNT(NULLIF(users.id,'')) as document_available"),
        )
            ->leftJoin('users', function($join) {
                $join->on('invoices.customer_id', '=', 'users.bin');
            })
            ->where([
                ['invoices.'.MainContract::RID,$rid],
                ['invoices.'.MainContract::STATUS,1],
            ])
            ->orderBy(MainContract::CREATED_AT)
            ->groupBy(DB::raw("DATE_FORMAT(invoices.created_at, '%d-%m-%Y')"))
            ->first();
    }

    public function create($data)
    {
        return Invoice::create($data);
    }

    public function pagination($data)
    {
        $query  =   Invoice::select(DB::raw("(count(id)) as data"));
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        return $query->first();
    }

    public function all($data): Collection|array
    {
        $query  =   Invoice::with(MainContract::INVOICE_STATUS);
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::ID,'DESC');
        return $query->get();
    }

    public function update($id,$data)
    {
        Invoice::where(MainContract::ID,$id)
            ->update($data);
        return $this->getById($id);
    }

    public function getById($id)
    {
        return Invoice::where([
            [MainContract::ID,$id],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function getByRid($rid)
    {
        return Invoice::where([
            [MainContract::RID,$rid],
            [MainContract::STATUS,1]
        ])->get();
    }

    public function getByCustomerId($customerId)
    {
        return Invoice::where([
            [MainContract::CUSTOMER_ID,$customerId],
            [MainContract::STATUS,1]
        ])->get();
    }

    public function delete($rid)
    {
        Invoice::where(MainContract::RID,$rid)->update([
            MainContract::STATUS    =>  0
        ]);
    }

}
