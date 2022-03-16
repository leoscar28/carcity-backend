<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserAuthRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Resources\User\UserResource;
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

    /**
     * @throws ValidationException
     */
    public function auth(UserAuthRequest $userAuthRequest): Response|Application|ResponseFactory|UserResource
    {
        $data   =   $userAuthRequest->check();
        $user   =   $this->userService->getByPhoneOrEmailOrAlias($data[MainContract::LOGIN]);
        if ($user && Hash::check($data[MainContract::PASSWORD],$user[MainContract::PASSWORD])) {
            return new UserResource($user);
        }
        return response(['message'  =>  'incorrect phone or password'],401);
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
