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
        // Получаем все смены
        $shifts = Shift::with('users')->get();

        // Преобразуем данные для вывода
        $result = [];
        foreach ($shifts as $shift) {
            // Определяем текстовое значение статуса
            $statusName = $shift->status ? 'Активна' : 'Не активна';
            // Создаем массив данных для текущей смены
            $shiftData = [
                'shift_id' => $shift->id,
                'date_start' => $shift->date_start,
                'date_end' => $shift->date_end,
                'status' => $shift->status,
                'status_name' => $statusName,
                'employees' => $shift->users->map(function ($user) {
                    // Возвращаем только необходимые данные сотрудника
                    return [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'patronymic' => $user->patronymic,
                    ];
                })->toArray(), // Преобразуем коллекцию в массив
            ];

            // Добавляем данные текущей смены в результирующий массив
            $result[] = $shiftData;
        }

        // Возвращаем данные в нужном формате
        return response()->json($result)->setStatusCode(200);
    }



    public function show(int $id) {
        // Находим смену по идентификатору
        $shift = Shift::with('users')->find($id);

        // Проверяем, существует ли смена
        if (!$shift) {
            throw new ApiException(404, 'Смена не найдена');
        }

        // Определяем текстовое значение статуса
        $statusName = $shift->status ? 'Активна' : 'Не активна';

        // Формируем данные о смене
        $shiftData = [
            'shift_id' => $shift->id,
            'date_start' => $shift->date_start,
            'date_end' => $shift->date_end,
            'status' => $shift->status,
            'status_name' => $statusName, // Добавляем название статуса
            'employees' => $shift->users->map(function ($user) {
                // Возвращаем только необходимые данные сотрудника
                return [
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'patronymic' => $user->patronymic,
                ];
            })->toArray(), // Преобразуем коллекцию в массив
        ];

        // Возвращаем данные о смене
        return response()->json(['data' => $shiftData]);
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
        return response()->json(['message' => 'Смена создана', 'data' => $shift])->setStatusCode(201);
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
        return response()->json(['message' => 'Смена '. $id. ' обновлена'])->setStatusCode(200);
    }
    public function deleteShift(int $id) {
        $shift = Shift::where('id', $id)->first();
        if(!$shift) {
            throw new ApiException(404, 'Не найдено');
        }
        $shift->delete();
        return response()->json(['message' => 'Смена '. $id. ' удалена'])->setStatusCode(200);
    }
    public function addUser(ShiftRequest $request, int $id) {
        $shift = Shift::where('id', $id)->first();
        // Проверяем существование смены
        if (!$shift) {
            throw new ApiException(404, 'Смена не найдена');
        }

        // Находим пользователя по ID и проверяем его роль
        $user = User::where('id', $request->input('user_id'))
            ->whereHas('roles', function ($query) {
                $query->where('code', 'employee');
            })
            ->first();

        // Проверяем существование пользователя и его роль
        if (!$user) {
            throw new ApiException(404, 'Пользователь не найден или не является сотрудником');
        }

        // Проверяем, не добавлен ли пользователь уже на другую смену
        if ($user->shift_id !== null) {
            throw new ApiException(400, 'Пользователь уже добавлен на другую смену');
        }

        // Присваиваем сотруднику ID смены и сохраняем изменения
        $user->shift_id = $id;
        $user->save();

        // Возвращаем успешный результат
        return response()->json([
            'message' => 'Пользователь ' . $request->input('user_id') . ' добавлен на смену ' . $id
        ])->setStatusCode(200);
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
