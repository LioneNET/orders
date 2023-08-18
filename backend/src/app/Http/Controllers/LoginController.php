<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest;
use App\Http\Resources\UserTokenResource;
use App\Services\UserService;

class LoginController extends Controller
{
    /**
     * Получение токена авторизации
     * @param UserAuthRequest $request
     * @return UserTokenResource
     * @throws \Exception
     */
    public function login(UserAuthRequest $request): UserTokenResource
    {
        return UserTokenResource::make(UserService::auth($request->validated()));
    }
}
