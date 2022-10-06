<?php


namespace App\Domain\Repositories\FeedbackRequest;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\FeedbackRequestContract;
use App\Models\FeedbackRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FeedbackRequestRepositoryEloquent implements FeedbackRequestRepositoryInterface
{
    public function getById($id): object|null
    {
        return FeedbackRequest::where(MainContract::ID,$id)->with(['messages', 'user'])->first();
    }

    public function create($data): ?object
    {
        $feedback = FeedbackRequest::create($data);
        return $this->getById($feedback->{MainContract::ID});
    }

    public function update($id,$data): ?object
    {
        FeedbackRequest::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function pagination($data)
    {
        $query  =   FeedbackRequest::select(DB::raw("(count(id)) as data"));

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
        $query  =   FeedbackRequest::select();

        $query->with(['firstMessage']);

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

        $query->orderBy(MainContract::CREATED_AT,'DESC');

        return $query->get();
    }

    public function close($id)
    {
        FeedbackRequest::where(MainContract::ID,$id)->update([
            MainContract::STATUS => FeedbackRequestContract::STATUS_CLOSE
        ]);
    }
}
