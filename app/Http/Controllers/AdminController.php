<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\AdminCreateUserRequest;
use App\Http\Requests\AdminUpdateUserRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
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
    public function createRole(CreateRoleRequest $request) {
        $role = new Role($request->all());
        $role->save();
        return response()->json('Роль создана')->setStatusCode(201);
    }
    public function updateRole(UpdateRoleRequest $request, int $id) {
        $role = Role::where('id', $id)->first();
        $role->fill($request->all());
        $role->save();
        return response()->json('Роль '.$id. ' обновлена')->setStatusCode(200);
    }
    public function deleteRole(int $id) {
        $role = Role::where('id', $id)->first();
        $role->delete();
        return response()->json('Роль '.$id. ' удалена')->setStatusCode(200);
    }
}
