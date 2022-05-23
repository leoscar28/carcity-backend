<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserAuthRequest;
use App\Http\Requests\User\UserCodeCheckRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserPasswordRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Jobs\SmsNotification;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService  =   $userService;
    }

    public function list()
    {
        return  \App\Models\User::all();
    }

    /**
     * @throws ValidationException
     */
    public function auth(UserAuthRequest $userAuthRequest): Response|Application|ResponseFactory|UserResource
    {
        $data = $userAuthRequest->check();
        $user = $this->userService->getByPhoneOrEmailOrAlias($data[MainContract::LOGIN]);
        if ($user && Hash::check($data[MainContract::PASSWORD], $user[MainContract::PASSWORD])) {
            return new UserResource($user);
        }
        return response(['message' => 'incorrect phone or password'], 401);
    }

    public function restore($phone): Response|Application|ResponseFactory|UserResource
    {
        if ($user = $this->userService->getByPhone($phone)) {
            $code   =   rand(1000,9999);
            $user->{MainContract::PHONE_CODE}   =   $code;
            $user->save();
            SmsNotification::dispatch($phone,$code);
            return new UserResource($user);
        }
        return response(['message' => 'Пользователь не найден'], 401);
    }

    /**
     * @throws ValidationException
     */
    public function update($id, UserUpdateRequest $userUpdateRequest): Response|Application|ResponseFactory|UserResource
    {
        if ($user = $this->userService->update($id,$userUpdateRequest->check())) {
            return new UserResource($user);
        }
        return response(['message'  =>  'Пользователя не существет!'],404);
    }

    /**
     * @throws ValidationException
     */
    public function codeCheck(UserCodeCheckRequest $userCodeCheckRequest): Response|Application|ResponseFactory|UserResource
    {
        $data   =   $userCodeCheckRequest->check();

        if ($user = $this->userService->getById($data[MainContract::ID])) {
            if (array_key_exists(MainContract::PHONE_CHECK,$data) && $data[MainContract::PHONE_CHECK] === (int)$user->{MainContract::PHONE_CODE}) {
                $user->{MainContract::PHONE_VERIFIED_AT}    =   now();
                $user->save();
            } elseif (array_key_exists(MainContract::EMAIL_CHECK,$data) && $data[MainContract::EMAIL_CHECK] === (int)$user->{MainContract::EMAIL_CODE}) {
                $user->{MainContract::EMAIL_VERIFIED_AT}    =   now();
                $user->save();
            } else {
                return response(['message'  =>  'Не правильный код'],400);
            }
            return new UserResource($user);
        }
        return response(['message'  =>  'Пользователь не найден'],404);
    }

    /**
     * @throws ValidationException
     */
    public function password($id, UserPasswordRequest $userPasswordRequest): Response|Application|ResponseFactory
    {
        $data   =   $userPasswordRequest->check();
        if ($user = $this->userService->getById($id)) {
            if (Hash::check($data[MainContract::OLD],$user->{MainContract::PASSWORD})) {
                $this->userService->update($id,[
                    MainContract::PASSWORD  =>  Hash::make($data[MainContract::PASSWORD])
                ]);
                return response(['message'  =>  'Пароль успешно сменен'],200);
            }
            return response(['message'  =>  'Текущии пароль не верный'],400);
        }
        return response(['message'  =>  'Пользователь не найден'],404);
    }

    /**
     * @throws ValidationException
     */
    public function create(UserCreateRequest $userCreateRequest): UserResource
    {
        return new UserResource($userCreateRequest->check());
    }

    public function getByToken($token): Response|Application|ResponseFactory|UserResource
    {
        if ($user = $this->userService->getByToken($token)) {
            return new UserResource($user);
        }
        return response(['message'  =>  'Пользователя не существет!'],404);
    }
}
