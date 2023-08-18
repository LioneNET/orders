<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public static function auth(array $validated) {
        $user = User::where('login', $validated['login'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw new \Exception('Некорректные учетные данные');
        }
        $user->token = $user->createToken($validated['device_name'])->plainTextToken;

        return $user;
    }
}
