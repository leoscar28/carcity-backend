<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
