<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFavorite\UserFavoriteAddRequest;
use App\Http\Requests\UserFavorite\UserFavoriteListRequest;
use App\Http\Resources\UserBanner\UserBannerCollection;
use App\Models\UserBanner;
use App\Models\UserFavorite;
use App\Services\UserFavoriteService;
use Illuminate\Validation\ValidationException;

class UserFavoriteController extends Controller
{
    protected UserFavoriteService $userFavoriteService;
    public function __construct(UserFavoriteService $userFavoriteService)
    {
        $this->userFavoriteService   =   $userFavoriteService;
    }


    /* @param UserFavoriteListRequest $userFavoriteListRequest
     * @return mixed
     * @throws ValidationException
     */
    public function pagination(UserFavoriteListRequest $userFavoriteListRequest)
    {
        return $this->userFavoriteService->pagination($userFavoriteListRequest->check());
    }

    /**
     * @param UserFavoriteListRequest $userFavoriteListRequest
     * @return UserBannerCollection
     * @throws ValidationException
     */
    public function all(UserFavoriteListRequest $userFavoriteListRequest)
    {

        $data = $userFavoriteListRequest->check();

        $ids = UserFavorite::where(MainContract::USER_ID, $data[MainContract::USER_ID])->get()->pluck('user_banner_id');

        if ($ids) {
            return new UserBannerCollection(UserBanner::whereIn(MainContract::ID, $ids)->get());
        }
        return new UserBannerCollection([]);
    }

    public function add(UserFavoriteAddRequest $request)
    {
        $this->userFavoriteService->add($request->check());
    }

    public function remove(UserFavoriteAddRequest $request)
    {
        $this->userFavoriteService->remove($request->check());
    }
}
