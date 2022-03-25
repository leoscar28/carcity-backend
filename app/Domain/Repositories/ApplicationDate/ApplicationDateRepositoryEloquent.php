<?php

namespace App\Domain\Repositories\ApplicationDate;

use App\Domain\Contracts\MainContract;
use App\Models\ApplicationDate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ApplicationDateRepositoryEloquent implements ApplicationDateRepositoryInterface
{
    public function getByRid($rid): object|null
    {
        return ApplicationDate::with(MainContract::APPLICATION,MainContract::APPLICATION_STATUS)
            ->where([
                [MainContract::RID,$rid],
                [MainContract::STATUS,1]
            ])->first();
    }

    public function pagination($data)
    {
        $query  =   ApplicationDate::select(DB::raw("(count(id)) as data"));
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        return $query->first();
    }

    public function list($data): Collection|array
    {
        $query  =   ApplicationDate::with(MainContract::APPLICATION,MainContract::APPLICATION_STATUS);
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
        ApplicationDate::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function create($data): object|null
    {
        $application    =   ApplicationDate::create($data);
        return $this->getById($application->{MainContract::ID});
    }

    public function getById($id): object|null
    {
        return ApplicationDate::with(MainContract::APPLICATION, MainContract::APPLICATION_STATUS)
            ->where([
                [MainContract::ID,$id],
                [MainContract::STATUS,1]
            ])->first();
    }

}
