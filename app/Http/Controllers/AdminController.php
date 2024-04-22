<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\AdminCreateUserRequest;
use App\Http\Requests\AdminUpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createUser(AdminCreateUserRequest $request) {
        $user = new User($request->all());
        $user->save();
        return response()->json()->setStatusCode(201);
    }
    public function updateUser(AdminUpdateUserRequest $request, int $id) {
        $user = User::where('id', $id)->first();
        if (!$user) {
            throw new ApiException(404, 'Не найдено');
        }
        $user->fill($request->all());
        $user->save();
        return response()->json(['message' => 'Пользователь ' . $id.' обновлён'])->setStatusCode(200);
    }
    public function deleteUser(int $id) {
        $user = User::where('id', $id)->first();
        if (!$user) {
            throw new ApiException(404, 'Не найдено');
        }
        $user->delete();
        return response()->json(['message' => 'Пользователь ' . $id.' удалён'])->setStatusCode(200);
    }
}
