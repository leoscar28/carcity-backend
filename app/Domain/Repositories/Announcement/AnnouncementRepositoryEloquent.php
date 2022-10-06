<?php


namespace App\Domain\Repositories\Announcement;

use App\Domain\Contracts\MainContract;
use App\Domain\Repositories\Announcement\AnnouncementRepositoryInterface;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AnnouncementRepositoryEloquent implements AnnouncementRepositoryInterface
{

    public function getById($id): object|null
    {
        return Announcement::where(MainContract::ID,$id)->with(['file', 'recipients'])->first();
    }

    public function pagination($data)
    {
        $query  =   Announcement::select(DB::raw("(count(id)) as data"));

        if (array_key_exists(MainContract::DATA,$data)) {
            $query->where($data[MainContract::DATA]);
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }

        return $query->first();
    }

    public function all($data): Collection|array
    {
        $query  =   Announcement::select();
        if (array_key_exists(MainContract::DATA,$data)) {
            $query->where($data[MainContract::DATA]);
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }

        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::UPDATED_AT,'DESC');
        return $query->get();
    }

    public function create($data)
    {
        $userAd = Announcement::create($data);
        return $this->getById($userAd->{MainContract::ID});
    }
}
