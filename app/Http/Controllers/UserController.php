<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Payment;
use App\Models\Role;
use App\Models\StatusOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function employees()
    {
        $employees = User::whereHas('roles', function ($query) {
                $query->where('code', 'employee');
            })->get();
        return response()->json(['data' => $employees])->setStatusCode(200);
    }
    //Статусы заказов
    public function statusOrders()
    {
        $statuses = StatusOrder::all();
        return response()->json(['data' => $statuses])->setStatusCode(200);
    }
    //Способы оплаты
    public function payments()
    {
        $payments = Payment::all();
        return response()->json(['data' => $payments])->setStatusCode(200);
    }
    //Метод регистрации
    public function create(CreateUserRequest $request)
    {
        $userData = $request->except('password');
        $user = new User($userData);
        $role = Role::where('code', 'user')->first();
        $user->role_id = $role->id;
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response()->json()->setStatusCode(201);
    }
    //Метод просмотра текущего профиля
    public function this()
    {
        $user=auth()->user()->load('shifts');
        return response()->json(['data'=>$user])->setStatusCode(200);
    }
    //Метод изменения пароля
    public function changePass(UpdateUserRequest $request)
    {
        $user = auth()->user();
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response()->json(['message' => 'Пароль изменен'])->setStatusCode(200);
    }
    // Просмотр всех пользователей
    public function index()
    {
        $users = User::with('roles', 'shifts')->get();
        if($users->isEmpty()) {
            throw new ApiException(404, 'Не найдено');
        }
        $users = $users->map(function ($user){
            $userArray = $user->toArray();
            $userArray['role'] = $user->roles->name;
            unset($userArray['roles']); // Удалить roles из основного массива
            return $userArray;
        });
        return response()->json(['data' => $users])->setStatusCode(200);
    }

    public function show(int $id)
    {
        $user = User::with('roles', 'shifts')->where('id', $id)->first();
        if (!$user) {
            throw new ApiException(404, 'Не найдено');
        }
        $userData = $user->toArray();
        $userData['role'] = $user->roles->name;
        unset($userData['roles']); // Удалить roles из основного массива
        return response()->json(['data' => $userData])->setStatusCode(200);
    }
}
