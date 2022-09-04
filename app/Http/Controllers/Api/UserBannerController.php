<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserBannerContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserBanner\UserBannerAddCommentRequest;
use App\Http\Requests\UserBanner\UserBannerCreateRequest;
use App\Http\Requests\UserBanner\UserBannerListRequest;
use App\Http\Requests\UserBanner\UserBannerRoomsRequest;
use App\Http\Requests\UserBanner\UserBannerUpdateRequest;
use App\Http\Resources\UserBanner\UserBannerCollection;
use App\Http\Resources\UserBanner\UserBannerResource;
use App\Jobs\UserBannerJob;
use App\Models\UserBanner;
use App\Models\UserBannerImage;
use App\Services\UserBannerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class UserBannerController extends Controller
{
    protected UserBannerService $userBannerService;
    public function __construct(UserBannerService $userBannerService)
    {
        $this->userBannerService   =   $userBannerService;
    }

    /**
     * @param UserBannerCreateRequest $userBannerCreateRequest
     * @return UserBannerResource
     */
    public function create(UserBannerCreateRequest $userBannerCreateRequest)
    {
        $data = $userBannerCreateRequest->check();

        $data[MainContract::CATEGORY_ID] = array_map('intval', explode(',', $data[MainContract::CATEGORY_ID]));
        $data[MainContract::BRAND_ID] =  array_map('intval', explode(',', $data[MainContract::BRAND_ID]));
        $data[MainContract::WEEKDAYS] =  array_map('intval', explode(',', $data[MainContract::WEEKDAYS]));
        $data[MainContract::TIME] =  explode(',', $data[MainContract::TIME]);

        if (array_key_exists(MainContract::IMAGES, $data)) {
            unset($data[MainContract::IMAGES]);
        }

        $userBanner = $this->userBannerService->create($data);

        if($userBannerCreateRequest->hasFile('images')) {
            $allowedExtension = ['jpg','png', 'jpeg', 'bmp'];

            $files = $userBannerCreateRequest->file('images');
            $errors = [];

            foreach ($files as $file) {
                if (in_array($file->getClientOriginalExtension(), $allowedExtension)) {

                    $new_file_name = md5($file->getClientOriginalName().random_int(1, 9999).time()).'.'.$file->getClientOriginalExtension();

                    $path = public_path('storage/banners/');
                    if (!file_exists($path)) {
                        mkdir($path, 755, true);
                    }
                    $resize_image = Image::make($file->getRealPath());

                    $resize_image
                        ->resize(800, null, function($constraint){
                            $constraint->aspectRatio();
                        })
                        ->resizeCanvas(800, 600, 'center', false, '#ffffff')
                        ->save($path  . $new_file_name);

                    UserBannerImage::create([
                        MainContract::USER_BANNER_ID => $userBanner->{MainContract::ID},
                        MainContract::TITLE => $file->getClientOriginalName(),
                        MainContract::PATH => 'banners/'.$new_file_name
                    ]);
                }
            }
        }

        UserBannerJob::dispatch($userBanner);

        return new UserBannerResource($userBanner);
    }

    /**
     * @param $id
     * @param UserBannerUpdateRequest $userBannerUpdateRequest
     * @return UserBannerResource|Response
     */
    public function update($id, UserBannerUpdateRequest $userBannerUpdateRequest): UserBannerResource|Response|Application|ResponseFactory
    {

        $data = $userBannerUpdateRequest->check();

        $data[MainContract::CATEGORY_ID] = array_map('intval', explode(',', $data[MainContract::CATEGORY_ID]));
        $data[MainContract::BRAND_ID] =  array_map('intval', explode(',', $data[MainContract::BRAND_ID]));
        $data[MainContract::WEEKDAYS] =  array_map('intval', explode(',', $data[MainContract::WEEKDAYS]));
        $data[MainContract::TIME] =  explode(',', $data[MainContract::TIME]);

        if (array_key_exists(MainContract::IMAGES, $data)) {
            unset($data[MainContract::IMAGES]);
        }

        $userBanner = $this->userBannerService->update($id, $data);

//UserBannerJob::dispatch($userBanner);

        if ($userBanner) {

            if($userBannerUpdateRequest->hasFile('images')) {
                $allowedExtension = ['jpg','png', 'jpeg', 'bmp'];

                $files = $userBannerUpdateRequest->file('images');
                $errors = [];

                foreach ($files as $file) {
                    if (in_array($file->getClientOriginalExtension(), $allowedExtension)) {

                        $new_file_name = md5($file->getClientOriginalName().random_int(1, 9999).time()).'.'.$file->getClientOriginalExtension();

                        $path = public_path('storage/banners/');
                        if (!file_exists($path)) {
                            mkdir($path, 755, true);
                        }
                        $resize_image = Image::make($file->getRealPath());

                        $resize_image
                            ->resize(800, null, function($constraint){
                                $constraint->aspectRatio();
                            })
                            ->resizeCanvas(800, 600, 'center', false, '#ffffff')
                            ->save($path  . $new_file_name);

                        UserBannerImage::create([
                            MainContract::USER_BANNER_ID => $userBanner->{MainContract::ID},
                            MainContract::TITLE => $file->getClientOriginalName(),
                            MainContract::PATH => 'banners/'.$new_file_name
                        ]);
                    }
                }
            }

            return new UserBannerResource($userBanner);
        }


        return response(['message'  =>  'Ad not found'],404);
    }

    /**
     * @param UserBannerListRequest $userBannerListRequest
     * @return mixed
     * @throws ValidationException
     */
    public function pagination(UserBannerListRequest $userBannerListRequest)
    {
        return $this->userBannerService->pagination($userBannerListRequest->check());
    }

    /**
     * @param UserBannerListRequest $userBannerListRequest
     * @return UserBannerCollection
     * @throws ValidationException
     */
    public function all(UserBannerListRequest $userBannerListRequest): UserBannerCollection
    {
        return new UserBannerCollection($this->userBannerService->all($userBannerListRequest->check()));
    }

    /**
     * @param UserBannerRoomsRequest $userBannerRoomsRequest
     * @return array
     * @throws ValidationException
     */
    public function rooms(UserBannerRoomsRequest $userBannerRoomsRequest): array
    {
        return $this->userBannerService->rooms($userBannerRoomsRequest->check());
    }

    public function getById($request): UserBannerResource|Response|Application|ResponseFactory
    {
        return response($request, 404);
        if ($userBanner = $this->userBannerService->getById($request)) {
            return new UserBannerResource($userBanner);
        }
        return response(['message'  =>  'Объявление не найдено'],404);
    }

     public function archive($id)
    {
        $this->userBannerService->archive($id);

        UserBannerJob::dispatch($this->userBannerService->getById($id));
    }

    public function delete($id)
    {
        $this->userBannerService->delete($id);
        UserBannerJob::dispatch($this->userBannerService->getById($id));
    }

    public function publish($id)
    {
        $resp = $this->userBannerService->publish($id);
        UserBannerJob::dispatch($this->userBannerService->getById($id));
        return $resp;
    }

    public function unpublish($id)
    {
        $this->userBannerService->unpublish($id);
        UserBannerJob::dispatch($this->userBannerService->getById($id));
    }

    public function activate($id)
    {
        $resp = $this->userBannerService->activate($id);
        UserBannerJob::dispatch($this->userBannerService->getById($id));
        return $resp;
    }

    public function needEdits($id, UserBannerAddCommentRequest $request)
    {
        $this->userBannerService->needEdits($id, $request->check());
        UserBannerJob::dispatch($this->userBannerService->getById($id));
    }

     public function showPhone($id)
    {
        $this->userBannerService->showPhone($id);
    }

    public function up($id)
    {
        $this->userBannerService->up($id);
    }

    public function count($type)
    {
        switch ($type){
            case 'new':
                $count = UserBanner::whereIn(MainContract::STATUS, [UserBannerContract::STATUS_CREATED, UserBannerContract::STATUS_UPDATED])->count();
                break;
            case 'active':
                $count = UserBanner::whereIn(MainContract::STATUS, [UserBannerContract::STATUS_NEED_EDITS, UserBannerContract::STATUS_PUBLISHED])->count();
                break;
            case 'inactive':
                $count = UserBanner::whereIn(MainContract::STATUS, [UserBannerContract::STATUS_INACTIVE, UserBannerContract::STATUS_NOT_PUBLISHED])->count();
                break;
            default:
                $count = UserBanner::count();
        }

        return $count;
    }

    public function removeImage(Request $data)
    {

        if (isset($data['id'], $data['user_banner_id'])) {
            $model = UserBannerImage::where(MainContract::ID, $data['id'])->where(MainContract::USER_BANNER_ID, $data['user_banner_id'])->first();
            if ($model) {
                $path = str_replace(URL::to('/').'/', '', $model->path);
                if(file_exists(public_path($path))) {
                   unlink(public_path($path));
                }
                return $model->delete();
            }
        }

        return false;
    }
}
