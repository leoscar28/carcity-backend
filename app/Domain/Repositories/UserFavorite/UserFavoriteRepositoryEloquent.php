<?php


namespace App\Domain\Repositories\UserFavorite;

use App\Domain\Contracts\MainContract;
use App\Models\UserFavorite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserFavoriteRepositoryEloquent implements UserFavoriteRepositoryInterface
{

    public function pagination($data)
    {
        $query  =   UserFavorite::select(DB::raw("(count(id)) as data"));

        if (array_key_exists(MainContract::DATA,$data)) {
            $query->where($data[MainContract::DATA]);
        }

        if (array_key_exists(MainContract::STATUS,$data)) {
            $query->whereIn(MainContract::STATUS, $data[MainContract::STATUS]);
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }

        return $query->first();
    }

    public function all($data): Collection|array
    {
        $query  =   UserFavorite::select();
        if (array_key_exists(MainContract::DATA,$data)) {
            $query->where($data[MainContract::DATA]);
        }

        if (array_key_exists(MainContract::STATUS,$data)) {
            $query->whereIn(MainContract::STATUS, $data[MainContract::STATUS]);
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }

        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::UPDATED_AT,'DESC');
        return $query->get();
    }

    public function add($data)
    {
        $model = UserFavorite::create($data);
    }

    public function remove($data)
    {
        $model = UserFavorite::where($data)->first();
        $model->delete();
    }
}
