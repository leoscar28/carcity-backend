<?php


namespace App\Domain\Repositories\UserBanner;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserBannerContract;
use App\Domain\Contracts\UserContract;
use App\Http\Requests\UserBanner\UserBannerAddCommentRequest;
use App\Models\Room;
use App\Models\User;
use App\Models\UserBanner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserBannerRepositoryEloquent implements UserBannerRepositoryInterface
{
    public function getById($id): object|null
    {
        UserBanner::where(MainContract::ID,$id)->increment('view_count', 1);

        return UserBanner::where(MainContract::ID,$id)->with(['images', 'room', 'user', 'reviews'])->first();
    }

    public function create($data): ?object
    {
        $userAd = UserBanner::create($data);
        return $this->getById($userAd->{MainContract::ID});
    }

    public function update($id,$data): ?object
    {
        $data[MainContract::STATUS] = UserBannerContract::STATUS_UPDATED;
        $data[MainContract::IS_PUBLISHED] = UserBannerContract::IS_NOT_PUBLISHED;

        UserBanner::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function pagination($data)
    {
        $query  =   UserBanner::select(DB::raw("(count(id)) as data"));

        if (array_key_exists(MainContract::DATA,$data)) {
            $query->where($data[MainContract::DATA]);
        }

        if (array_key_exists(MainContract::COMPANY,$data)) {

            $customerIds = User::where(UserContract::ROLE_ID, 1)->where(UserContract::COMPANY, 'like', '%'.$data[MainContract::COMPANY].'%')->get()->pluck('id')->toArray();
            $query->whereIn(MainContract::USER_ID, $customerIds);
        }

        if (array_key_exists(MainContract::STATUS,$data)) {
            $query->whereIn(MainContract::STATUS, $data[MainContract::STATUS]);
        }

        if (array_key_exists(MainContract::BRAND_ID,$data)) {
            $query->where(function ($query) use ($data) {
                foreach($data[MainContract::BRAND_ID] as $brand_id) {
                    $query->orWhereJsonContains(MainContract::BRAND_ID, $brand_id);
                }
            });
        }

        if (array_key_exists(MainContract::CATEGORY_ID,$data)) {
            $query->where(function ($query) use ($data) {
                foreach($data[MainContract::CATEGORY_ID] as $category_id) {
                    $query->orWhereJsonContains(MainContract::CATEGORY_ID, $category_id);
                }
            });
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }

        if (array_key_exists(MainContract::TERM,$data) && $data[MainContract::TERM]) {
            $query->where(function ($query) use ($data) {
                $query->orWhere(MainContract::TITLE, 'like', '%'.$data[MainContract::TERM].'%');
                $query->orWhere(MainContract::DESCRIPTION, 'like', '%'.$data[MainContract::TERM].'%');
            });
        }

        if (array_key_exists(MainContract::WITH_IMAGE,$data) && $data[MainContract::WITH_IMAGE] == 1) {
            $query->with(['images'])->has('images');
        }

        return $query->first();
    }

    public function all($data): Collection|array
    {
        $query  =   UserBanner::select();

        $query->with(['images', 'room', 'user']);

        if (array_key_exists(MainContract::DATA,$data)) {
            $query->where($data[MainContract::DATA]);
        }

        if (array_key_exists(MainContract::COMPANY,$data)) {

            $customerIds = User::where(UserContract::ROLE_ID, 1)->where(UserContract::COMPANY, 'like', '%'.$data[MainContract::COMPANY].'%')->get()->pluck('id')->toArray();
            $query->whereIn(MainContract::USER_ID, $customerIds);
        }

        if (array_key_exists(MainContract::STATUS,$data)) {
            $query->whereIn(MainContract::STATUS, $data[MainContract::STATUS]);
        }

        if (array_key_exists(MainContract::BRAND_ID,$data)) {
            $query->where(function ($query) use ($data) {
                foreach($data[MainContract::BRAND_ID] as $brand_id) {
                    $query->orWhereJsonContains(MainContract::BRAND_ID, $brand_id);
                }
            });
        }

        if (array_key_exists(MainContract::CATEGORY_ID,$data)) {
            $query->where(function ($query) use ($data) {
                foreach($data[MainContract::CATEGORY_ID] as $category_id) {
                    $query->orWhereJsonContains(MainContract::CATEGORY_ID, $category_id);
                }
            });
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }

        if (array_key_exists(MainContract::TERM,$data) && $data[MainContract::TERM]) {
            $query->where(function ($query) use ($data) {
                $query->orWhere(MainContract::TITLE, 'like', '%'.$data[MainContract::TERM].'%');
                $query->orWhere(MainContract::DESCRIPTION, 'like', '%'.$data[MainContract::TERM].'%');
            });
        }

        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);

        if (isset($data[MainContract::SORT]) && isset($data[MainContract::ORDER_BY])) {
            if ($data[MainContract::ORDER_BY] === 'updated') {
                $query->orderBy(MainContract::UPDATED_AT, $data[MainContract::SORT]);
            } else if ($data[MainContract::ORDER_BY] === 'rating') {
                $query->withCount(['reviewsOnUser as rating' => function($query){
                    $query->select(DB::raw('coalesce(avg(rating), 0)'));
                }])->orderBy(MainContract::RATING, $data[MainContract::SORT]);
            }  else if ($data[MainContract::ORDER_BY] === 'review') {
                $query->withCount(['reviewsOnUser as count' => function($query){
                    $query->select(DB::raw('COUNT(*)'));
                }])->orderBy('count', $data[MainContract::SORT]);
            }

        } else {
            $query->orderBy(MainContract::UPDATED_AT,'DESC');
        }


        if (array_key_exists(MainContract::WITH_IMAGE,$data) && $data[MainContract::WITH_IMAGE] == 1) {
            $query->has('images');
        }


        return $query->get();
    }

    public function rooms($data)
    {
        $query  =   UserBanner::select();
        $query2 = User::select();

        if (array_key_exists(MainContract::DATA,$data)) {
            $query->where($data[MainContract::DATA]);
        }

        if (array_key_exists(MainContract::STATUS,$data)) {
            $query->whereIn(MainContract::STATUS, $data[MainContract::STATUS]);
        }

        if (array_key_exists(MainContract::BRAND_ID,$data) && count($data[MainContract::BRAND_ID]) > 0) {
            $query->where(function ($query) use ($data) {
                foreach($data[MainContract::BRAND_ID] as $brand_id) {
                    $query->orWhereJsonContains(MainContract::BRAND_ID, $brand_id);
                }
            });
            if ($data[MainContract::DATA][MainContract::TYPE] == 1) {
                $query2->whereIn(MainContract::BRAND_ID, $data[MainContract::BRAND_ID]);
            }
        }
        if (array_key_exists(MainContract::CATEGORY_ID,$data)&& count($data[MainContract::CATEGORY_ID]) > 0) {
            $query->where(function ($query) use ($data) {
                foreach($data[MainContract::CATEGORY_ID] as $category_id) {
                    $query->orWhereJsonContains(MainContract::CATEGORY_ID, $category_id);
                }
            });

            if ($data[MainContract::DATA][MainContract::TYPE] == 1) {
                $query2->whereIn(MainContract::SPARE_PART_ID, $data[MainContract::CATEGORY_ID]);
            } else {
                $query2->whereIn(MainContract::SERVICE_ID, $data[MainContract::CATEGORY_ID]);
            }
        }

        if (array_key_exists(MainContract::TERM,$data) && $data[MainContract::TERM]) {
            $query->where(function ($query) use ($data) {
                $query->orWhere(MainContract::TITLE, 'like', '%'.$data[MainContract::TERM].'%');
                $query->orWhere(MainContract::DESCRIPTION, 'like', '%'.$data[MainContract::TERM].'%');
            });
        }

        $roomsFromBanners = $query->pluck('room_id')->toArray();
        $users = $query2->pluck('id')->toArray();

        if ($users) {
            $roomsFromUsers = Room::whereIn(MainContract::USER_ID, $users)->pluck('id')->toArray();
            $roomsFromBanners = array_merge_recursive($roomsFromBanners,$roomsFromUsers);
        }

        return array_values(array_unique($roomsFromBanners));
    }

    public function needEdits($id, $data)
    {
        UserBanner::where(MainContract::ID,$id)->update([
            MainContract::STATUS => UserBannerContract::STATUS_NEED_EDITS,
            MainContract::COMMENT => $data['comment']
        ]);
    }

    public function publish($id)
    {
        $model = UserBanner::where(MainContract::ID,$id)->first();

        $user = User::where(MainContract::ID, $model->user_id)->first();
        $count = UserBanner::where(MainContract::USER_ID, $user->id)->where(MainContract::STATUS, UserBannerContract::STATUS_PUBLISHED)->count();

        if ($count < $user->limit) {
            UserBanner::where(MainContract::ID,$id)->update([
                MainContract::STATUS    => UserBannerContract::STATUS_PUBLISHED,
                MainContract::PUBLISHED_AT    => now()
            ]);

            return true;
        }

        UserBanner::where(MainContract::ID,$id)->update([
            MainContract::STATUS    => UserBannerContract::STATUS_NOT_PUBLISHED
        ]);

        return false;
    }

    public function unpublish($id)
    {
        UserBanner::where(MainContract::ID,$id)->update([
            MainContract::STATUS => UserBannerContract::STATUS_NOT_PUBLISHED
        ]);
    }

    public function activate($id)
    {
        $model = UserBanner::where(MainContract::ID,$id)->with(['user'])->first();

        $user = User::where(MainContract::ID, $model->user_id)->first();

        $count = UserBanner::where(MainContract::USER_ID, $user->id)->where(MainContract::STATUS, UserBannerContract::STATUS_PUBLISHED)->count();

        if ($count < $user->limit) {
            UserBanner::where(MainContract::ID,$id)->update([
                MainContract::STATUS    => UserBannerContract::STATUS_PUBLISHED,
                MainContract::PUBLISHED_AT    => now()
            ]);

            return true;
        }

        UserBanner::where(MainContract::ID,$id)->update([
            MainContract::STATUS    => UserBannerContract::STATUS_NOT_PUBLISHED
        ]);

        return false;
    }

    public function delete($id)
    {
        $model = UserBanner::where(MainContract::ID,$id)->first();
        $model->delete();
    }

    public function archive($id)
    {
        UserBanner::where(MainContract::ID,$id)->update([
            MainContract::STATUS    => UserBannerContract::STATUS_INACTIVE,
        ]);
    }

     public function showPhone($id)
    {
        UserBanner::where(MainContract::ID,$id)->increment('phone_view_count', 1);
    }

    public function up($id)
    {
        UserBanner::where(MainContract::ID,$id)->update([
            MainContract::UP => 1,
        ]);
    }
}
