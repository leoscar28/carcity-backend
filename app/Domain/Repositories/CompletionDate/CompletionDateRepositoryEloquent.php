<?php

namespace App\Domain\Repositories\CompletionDate;

use App\Domain\Contracts\MainContract;
use App\Models\CompletionDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CompletionDateRepositoryEloquent implements CompletionDateRepositoryInterface
{

    public function getByRid($rid): object|null
    {
        return CompletionDate::with(MainContract::COMPLETION,MainContract::COMPLETION_STATUS)
            ->where([
                [MainContract::RID,$rid],
                [MainContract::STATUS,1]
            ])->first();
    }

    public function pagination($data)
    {
        $query  =   CompletionDate::select(DB::raw("(count(id)) as data"));
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        return $query->first();
    }

    public function list($data): Collection|array
    {
        $query  =   CompletionDate::with(MainContract::COMPLETION,MainContract::COMPLETION_STATUS);
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::ID,'DESC');
        return $query->get();
    }

    public function update($id,$data): object|null
    {
        CompletionDate::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function create($data): object|null
    {
        $completion =   CompletionDate::create($data);
        return $this->getById($completion->{MainContract::ID});
    }

    public function getById($id): object|null
    {
        return CompletionDate::with(MainContract::COMPLETION,MainContract::COMPLETION_STATUS)
            ->where([
                [MainContract::ID,$id],
                [MainContract::STATUS,1]
            ])->first();
    }
}
