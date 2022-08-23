<?php

namespace App\Domain\Repositories\Completion;

use App\Domain\Contracts\CompletionContract;
use App\Domain\Contracts\MainContract;
use App\Models\Completion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class CompletionRepositoryEloquent implements CompletionRepositoryInterface
{

    #[ArrayShape(['data' => "int"])] public function paginationByCustomerAndNumber($data): array
    {
        if (array_key_exists(MainContract::COMPANY,$data)) {
            $data[MainContract::DATA][] =   [MainContract::CUSTOMER,'like','%'.$data[MainContract::COMPANY].'%'];
        }
        if (array_key_exists(MainContract::NUMBER,$data)) {
            $data[MainContract::DATA][] =   [MainContract::NUMBER,'like',$data[MainContract::NUMBER].'%'];
        }
        $query  =   Completion::select(MainContract::RID);
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $res    =   $query->groupBy(MainContract::RID)->get();
        $arr    =   [];
        foreach ($res as &$item) {
            $arr[]  =   $item->{MainContract::RID};
        }
        return ['data'  =>  sizeof(array_unique($arr))];
    }

    public function getByCustomerAndNumber($data): Collection|array
    {
        $query  =   Completion::with(MainContract::COMPLETION_STATUS);
        $query->where([
            [MainContract::STATUS,1],
        ]);
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
        return Completion::select(
            DB::raw("(min(completions.upload_status_id)) as upload_status_id"),
            DB::raw("(count(completions.id)) as document_all"),
            DB::raw("(DATE_FORMAT(completions.created_at, '%d-%m-%Y')) as created_at"),
            DB::raw("COUNT(NULLIF(users.id,'')) as document_available"),
        )
            ->leftJoin('users', function($join) {
                $join->on('completions.customer_id', '=', 'users.bin');
            })
            ->where([
                ['completions.'.MainContract::RID,$rid],
                ['completions.'.MainContract::STATUS,1]
            ])
            ->orderBy(MainContract::CREATED_AT)
            ->groupBy(DB::raw("DATE_FORMAT(completions.created_at, '%d-%m-%Y')"))
            ->first();
    }

    public function create($data)
    {
        return Completion::create($data);
    }

    public function pagination($data)
    {
        $query  =   Completion::select(DB::raw("(count(id)) as data"));
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        return $query->first();
    }

    public function all($data): Collection|array
    {
        $query  =   Completion::with(MainContract::COMPLETION_STATUS);
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
        Completion::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getById($id)
    {
        return Completion::where([
            [MainContract::ID,$id],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function getByRidAndUploadStatusId($rid,$uploadStatusId)
    {
        return Completion::where([
            [MainContract::RID,$rid],
            [MainContract::UPLOAD_STATUS_ID,$uploadStatusId],
            [MainContract::STATUS,1]
        ])->limit(500)->get();
    }

    public function getByIds($ids)
    {
        return Completion::where(MainContract::STATUS,1)
            ->whereIn(MainContract::ID,$ids)
            ->get();
    }

    public function getByRid($rid)
    {
        return Completion::where([
            [MainContract::RID,$rid],
            [MainContract::STATUS,1]
        ])->get();
    }

    public function getByCustomerId($customerId)
    {
        return Completion::where([
            [MainContract::CUSTOMER_ID,$customerId],
            [MainContract::STATUS,1]
        ])->get();
    }

    public function delete($rid)
    {
        Completion::where(MainContract::RID,$rid)->update([
            MainContract::STATUS    =>  0
        ]);
    }

}
