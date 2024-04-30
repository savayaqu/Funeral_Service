<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json(['data'=> $roles])->setStatusCode(200);
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
