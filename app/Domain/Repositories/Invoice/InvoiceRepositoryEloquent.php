<?php

namespace App\Domain\Repositories\Invoice;

use App\Domain\Contracts\MainContract;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;

class InvoiceRepositoryEloquent implements InvoiceRepositoryInterface
{

    #[ArrayShape(['data' => "int"])] public function paginationByCustomerAndNumber($data): array
    {
        if (array_key_exists(MainContract::COMPANY,$data)) {
            $data[MainContract::DATA][] =   [MainContract::CUSTOMER,'like','%'.$data[MainContract::COMPANY].'%'];
        }
        if (array_key_exists(MainContract::NUMBER,$data)) {
            $data[MainContract::DATA][] =   [MainContract::NUMBER,'like',$data[MainContract::NUMBER].'%'];
        }
        $query  =   Invoice::groupBy(MainContract::RID)->select(MainContract::RID);
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $res    =   $query->get();
        Log::info('rid-invoice',[$res]);
        $arr    =   [];
        foreach ($res as &$item) {
            $arr[]  =   $item->{MainContract::RID};
        }

        return ['data'  =>  sizeof(array_unique($arr))];
    }

    public function getByCustomerAndNumber($data): Collection|array
    {
        $query  =   Invoice::with(MainContract::INVOICE_STATUS);
        $query->where(MainContract::STATUS,1);
        if (array_key_exists(MainContract::COMPANY,$data)) {
            $query->where(MainContract::CUSTOMER,'like','%'.$data[MainContract::COMPANY].'%');
        }
        if (array_key_exists(MainContract::NUMBER,$data)) {
            $query->where(MainContract::NUMBER,'like',$data[MainContract::NUMBER].'%');
        }
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::ID,'DESC');
        return $query->get();
    }

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

    public function getByIds($ids)
    {
        return Invoice::where(MainContract::STATUS,1)
            ->whereIn(MainContract::ID,$ids)
            ->get();
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
