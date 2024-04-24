<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Order;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function attach(int $orderId)
    {
        $user = auth()->user();
        $order = Order::where('id', $orderId)->first();
        if(!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        $order->employee_id = $user->id;
        $order->save();
        return response()->json(['message' => 'Вы прикрепились к заказу '. $orderId])->setStatusCode(200);
    }
    public function detach(int $orderId)
    {
        $user = auth()->user();
        $order = Order::where('id', $orderId)->first();
        if(!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        $order->employee_id = NULL;
        $order->save();
        return response()->json(['message' => 'Вы открепились от заказа '. $orderId])->setStatusCode(200);
    }
}
