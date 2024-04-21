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
        $user = User
            ::where('login',    $request->login)
            ->where('password', $request->password)
            ->first();
        if(!$user) {
            throw new ApiException(401, 'Несанкционированный');
        }
        $user->api_token = Hash::make(microtime(true)*1000 . Str::random());
        $user->save();
        return response(['data' => $user])->setStatusCode(200);
    }
    //Метод выхода
    public function logout(Request $request)
    {
        $user = $request->user();
        if(!$user) {
            throw new ApiException(401, 'Несанкционированный');
        }
        $user->api_token = null;
        $user->save();
        return response()->json()->setStatusCode(204);
    }
}