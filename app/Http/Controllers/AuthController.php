<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Метод авторизации
    public function login(LoginRequest $request)
    {
        $user = User::with('roles')->where('login', $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new ApiException(401, 'Ошибка авторизации');
        }

        $user->api_token = Hash::make(microtime(true) * 1000 . Str::random());
        $user->save();

        return response(['api_token' => $user->api_token, 'role' => $user->roles->name])->setStatusCode(200);
    }

    //Метод выхода
    public function logout(Request $request)
    {
        $user = $request->user();
        if(!$user) {
            throw new ApiException(401, 'Ошибка авторизации');
        }
        $user->api_token = null;
        $user->save();
        return response()->json()->setStatusCode(204);
    }
}
