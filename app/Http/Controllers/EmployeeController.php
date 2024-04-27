<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\AddEmployeeOrderRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Прикрепление сотрудника к заказу
    public function attach(int $orderId, AddEmployeeOrderRequest $request)
    {
        $userMe = auth()->user();
        $userEmployee = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('code', 'employee');
        })->where('id', $userMe->id)->first();
        $order = Order::where('id', $orderId)->first();
        if(!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        if($userEmployee) {
            $order->employee_id = $userEmployee->id;
            $order->save();
            return response()->json(['message' => 'Вы прикрепились к заказу '. $orderId])->setStatusCode(200);
        } else {
            $order->employee_id = $request->input('employee_id');
            $order->save();
            return response()->json(['message' => 'Сотрудник ' . $order->employee_id.' прикреплен к заказу '. $orderId])->setStatusCode(200);
        }
    }
    // Открепление сотрудника от заказа
    public function detach(int $orderId)
    {
        $userMe = auth()->user();
        $userEmployee = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('code', 'employee');
        })->where('id', $userMe->id)->first();
        $order = Order::where('id', $orderId)->first();
        if(!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        if($userEmployee) {
            $order->employee_id = NULL;
            $order->save();
            return response()->json(['message' => 'Вы открепились от заказа ' . $orderId])->setStatusCode(200);
        } else {
            $order->employee_id = NULL;
            $order->save();
            return response()->json(['message' => 'Сотрудник ' . $order->employee_id.' откреплён от заказа '. $orderId])->setStatusCode(200);
        }
    }
}
