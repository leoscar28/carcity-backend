<?php

namespace App\Domain\Repositories\Completion;

use App\Domain\Contracts\CompletionContract;
use App\Domain\Contracts\MainContract;
use App\Models\Completion;
use Illuminate\Support\Facades\DB;

class CompletionRepositoryEloquent implements CompletionRepositoryInterface
{

    public function list($rid)
    {
        return Completion::select(
            DB::raw("(min(upload_status_id)) as upload_status_id"),
            DB::raw("(count(id)) as document_all"),
            DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as created_at"),
        )
            ->where([
                [MainContract::RID,$rid],
                [MainContract::STATUS,1]
            ])
            ->orderBy(MainContract::CREATED_AT)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
            ->first();
    }

    public function create($data)
    {
        return Completion::create($data);
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

    public function getByRid($rid)
    {
        return Completion::where([
            [MainContract::RID,$rid],
            [MainContract::STATUS,1]
        ])->get();
    }

}
