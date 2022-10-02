<?php


namespace App\Domain\Repositories\AnnouncementRecipient;

use App\Domain\Contracts\MainContract;
use App\Domain\Repositories\Announcement\AnnouncementRepositoryInterface;
use App\Models\Announcement;
use App\Models\AnnouncementRecipient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AnnouncementRecipientRepositoryEloquent implements AnnouncementRecipientRepositoryInterface
{

    public function getById($id): object|null
    {
        return AnnouncementRecipient::where(MainContract::ID,$id)->with(['announcement', 'file', 'user'])->first();
    }

    public function pagination($data)
    {
        $query  =   AnnouncementRecipient::select(DB::raw("(count(id)) as data"));

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
        $query  =   AnnouncementRecipient::select();
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
        $userAd = AnnouncementRecipient::create($data);
        return $this->getById($userAd->{MainContract::ID});
    }

    public function setView($id): ?object
    {
        $data = [MainContract::VIEW => 1];

        AnnouncementRecipient::where(MainContract::ID,$id)->update($data);

        return $this->getById($id);
    }

    public function getNotViewed($data)
    {
        return AnnouncementRecipient::where(MainContract::USER_ID,$data[MainContract::USER_ID])
            ->where(MainContract::VIEW, 0)->first();
    }
}
