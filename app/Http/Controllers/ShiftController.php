<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\CreateShiftRequest;
use App\Http\Requests\ShiftRequest;
use App\Http\Requests\UpdateShiftRequest;
use App\Models\Shift;

use App\Models\User;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index() {
        $shifts = Shift::all();
        return response()->json(['data' => $shifts])->setStatusCode(200);
    }
    public function show(int $id) {
        $shift = Shift::where('id', $id)->first();
        if(!$shift) {
            throw new ApiException(404, 'Не найдено');
        }
        return response()->json(['data' => $shift]);
    }
    public function createShift(CreateShiftRequest $request) {
        $shift = new Shift($request->all());
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        if($date_start === $date_end) {
            throw new ApiException(400, 'Некорректный запрос');
        }
        if($request->input('date_start'))
        $shift->save();
        return response()->json('Смена создана')->setStatusCode(201);
    }
    public function updateShift(UpdateShiftRequest $request, int $id) {
        $shift = Shift::where('id', $id)->first();
        if(!$shift) {
            throw new ApiException(404, 'Не найдено');
        }
        if($request->input('date_start') === $request->input('date_end')) {
            throw new ApiException(400, 'Некорректный запрос');
        }
        $shift->fill($request->all());
        $shift->save();
        return response()->json('Смена '. $id. ' обновлена')->setStatusCode(200);
    }
    public function deleteShift(int $id) {
        $shift = Shift::where('id', $id)->first();
        if(!$shift) {
            throw new ApiException(404, 'Не найдено');
        }
        $shift->delete();
        return response()->json('Смена '. $id. ' удалена')->setStatusCode(200);
    }
    public function addUser(ShiftRequest $request, int $id) {
        $shift = Shift::where('id', $id)->first();
        if(!$shift) {
            throw new ApiException(404, 'Не найдено');
        }
        $user = User::where('id', $request->input('user_id'))
            ->whereHas('roles', function ($query) {
                $query->where('code', 'employee');
            })
            ->first();
        if (!$user) {
            throw new ApiException(404, 'Не найдено');
        }
        if ($user->shift_id != NULL) {
            throw new ApiException(406, 'Пользователь находится на смене ' . $user->shift_id);
        }
        $user->shift_id = $id;
        $user->save();
        return response()->json(['message' => 'Пользователь ' . $request->input('user_id') . ' добавлен на смену ' . $id])->setStatusCode(200);
    }
    public function deleteUser(ShiftRequest $request, int $id) {
        $shift = Shift::where('id', $id)->first();
        if(!$shift) {
            throw new ApiException(404, 'Не найдено');
        }
        $user = User::where('id', $request->input('user_id'))->first();
        if (!$user) {
            throw new ApiException(404, 'Не найдено');
        }
        $user->shift_id = NULL;
        $user->save();
        return response()->json(['message' => 'Пользователь ' . $request->input('user_id') . ' удалён со смены ' . $id])->setStatusCode(200);
    }
}
