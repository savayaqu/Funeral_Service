<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Cart;
use App\Models\Compound;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //Метод оформления заказа
    public function checkout(CreateOrderRequest $request) {
        // Получаем текущее время
        $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
        // Получаем данные пользователя
        $user = Auth::user();
        $paymentId = $request->input('payment_id');
        // Создаем заказ
        $order = new Order([
            'date_order' => $currentDateTime,
            'payment_id' => $paymentId,
            'user_id' => $user->id,
            'status_order_id' => 1, //Формируется
        ]);
        $order->save();
        // Получаем товары из корзины пользователя
        $cartItems = Cart::where('user_id', $user->id)->get();
        //Если товаров нет, то выводим сообщение об ошибке
        if($cartItems->isEmpty()) {
            throw new ApiException(404, 'Не удалось оформить заказ, возможно, ваша корзина пуста');
        }
        foreach ($cartItems as $cartItem) {
            // Находим товар по его ID
            $product = Product::find($cartItem->product_id);
            if (!$product) {
                // Если товар не найден, пропускаем его
                continue;
            }
            // Проверяем, достаточно ли товара для оформления заказа
            if ($product->quantity < $cartItem->quantity) {
                return response()->json(['error' => 'Недостаточное количество товара в наличии'], 400);
            }
            // Уменьшаем количество товара в таблице Product
            $product->quantity -= $cartItem->quantity;
            $product->save();
            $total_price = $cartItem->quantity * $product->price;
            // Создаем состав заказа (Compound)
            $compound = new Compound([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'total_price' => $total_price,
            ]);
            $compound->save();
            // Удаляем товар из корзины пользователя
            $cartItem->delete();
        }
        // Возвращаем ответ с сообщением об успешном оформлении заказа
        return response()->json(['message' => 'Заказ успешно оформлен'], 200);
    }
}
