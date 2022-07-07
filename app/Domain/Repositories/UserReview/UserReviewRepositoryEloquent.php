<?php


namespace App\Domain\Repositories\UserReview;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserReviewContract;
use App\Models\AntimatWord;
use App\Models\UserReview;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserReviewRepositoryEloquent implements UserReviewRepositoryInterface
{

    public function getById($id): object|null
    {
        return UserReview::where(MainContract::ID,$id)->first();
    }

    public function create($data): ?object
    {
        if ($data[MainContract::DESCRIPTION] != AntimatWord::replace($data[UserReviewContract::DESCRIPTION])) {
            $data[MainContract::STATUS] = UserReviewContract::STATUS_INACTIVE;
            $data[MainContract::COMMENT] = 'Сообщение содержит нецензурные выражения';
        }

        $model = UserReview::create($data);
        return $this->getById($model->{MainContract::ID});
    }

    public function pagination($data)
    {
        $query  =   UserReview::select(DB::raw("(count(id)) as data"));

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
        $query  =   UserReview::select();
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

    public function delete($id, $data)
    {
        UserReview::where(MainContract::ID,$id)->update([
            MainContract::STATUS => UserReviewContract::STATUS_INACTIVE,
            MainContract::COMMENT => $data['comment']
        ]);
    }
}
