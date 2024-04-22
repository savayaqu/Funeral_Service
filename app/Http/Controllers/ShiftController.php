<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\ShiftRequest;
use App\Models\Shift;

use App\Models\User;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function addUser(ShiftRequest $request, int $id) {
        $shift = Shift::where('id', $id)->first();
        if(!$shift) {
            throw new ApiException(404, 'Смена не найдена');
        }
        $user = User::where('id', $request->input('user_id'))
            ->whereHas('roles', function ($query) {
                $query->where('code', 'employee');
            })
            ->first();
        if (!$user) {
            throw new ApiException(404, 'Пользователь не найден или не является сотрудником');
        }
        $user->shift_id = $id;
        $user->save();
        return response()->json(['message' => 'Пользователь ' . $id . ' обновлён'])->setStatusCode(200);
    }
    public function deleteUser(ShiftRequest $request, int $id) {
        $shift = Shift::where('id', $id)->first();
        if(!$shift) {
            throw new ApiException(404, 'Смена не найдена');
        }
        $user = User::where('id', $request->input('user_id'))->first();
        if (!$user) {
            throw new ApiException(404, 'Пользователь не найден');
        }
        $user->shift_id = NULL;
        return response()->json(['message'=> 'Пользователь '.$request->input('user_id').' удалён со смены '.$id])->setStatusCode(200);
    }
}
