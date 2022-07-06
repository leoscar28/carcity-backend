<?php


namespace App\Domain\Repositories\UserRequest;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserRequestContract;
use App\Models\UserRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserRequestRepositoryEloquent implements UserRequestRepositoryInterface
{

    public function getById($id): object|null
    {
        return UserRequest::where(MainContract::ID,$id)->first();
    }

    public function create($data): ?object
    {
        $model = UserRequest::create($data);
        return $this->getById($model->{MainContract::ID});
    }

    public function pagination($data)
    {
        $query  =   UserRequest::select(DB::raw("(count(id)) as data"));

        if (array_key_exists(MainContract::DATA,$data)) {
            $query->where($data[MainContract::DATA]);
        }

        if (array_key_exists(MainContract::STATUS,$data)) {
            $query->whereIn(MainContract::STATUS, $data[MainContract::STATUS]);
        }

        if (array_key_exists(MainContract::CATEGORY_ID,$data)) {
            $query->whereIn(MainContract::CATEGORY_ID, $data[MainContract::CATEGORY_ID]);
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }

        return $query->first();
    }

    public function all($data): Collection|array
    {
        $query  =   UserRequest::select();
        if (array_key_exists(MainContract::DATA,$data)) {
            $query->where($data[MainContract::DATA]);
        }

        if (array_key_exists(MainContract::STATUS,$data)) {
            $query->whereIn(MainContract::STATUS, $data[MainContract::STATUS]);
        }

        if (array_key_exists(MainContract::CATEGORY_ID,$data)) {
            $query->whereIn(MainContract::CATEGORY_ID, $data[MainContract::CATEGORY_ID]);
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }

        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::CREATED_AT,'DESC');
        return $query->get();
    }

    public function unpublish($id)
    {
        UserRequest::where(MainContract::ID,$id)->update([
            MainContract::STATUS => UserRequestContract::STATUS_INACTIVE
        ]);
    }
}
