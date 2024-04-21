<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Метод регистрации
    public function create(CreateUserRequest $request)
    {
        $user = new User($request->all());
        $role = Role::where('code', 'user')->first();
        $user->role_id = $role->id;
        $user->save();
        return response()->json()->setStatusCode(201);
    }
    //Метод просмотра текущего профиля
    public function this()
    {
        $user=auth()->user();
        return response(['data'=>$user])->setStatusCode(200);
    }

}
