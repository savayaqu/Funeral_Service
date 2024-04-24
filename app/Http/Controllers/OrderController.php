<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\AddEmployeeOrderRequest;
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
    //Прикпрепление сотрудника к заказу
    public function addEmployee(AddEmployeeOrderRequest $request, int $orderId) {
        $order = Order::where('id', $orderId)->first();
        if(!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        $order->employee_id = $request->input('employee_id');
        $order->save();
        return response()->json(['message' => `Сотрудник ${$order->employee_id} прикреплен к заказу ${orderId}`])->setStatusCode(200);
    }
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
            throw new ApiException(404, 'Не найдено');
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
                throw new ApiException(400, 'Некорректный запрос');
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
    //Просмотр всех заказов
    public function index()
    {
        $compounds = Compound::with('orders.status_orders', 'products', 'orders.employees', 'orders.users')->get();

        // Преобразуем коллекцию, чтобы включить имена статусов заказов и имена продуктов
        $compounds = $compounds->map(function ($compound) {
            $employee = $compound->orders->employees;
            $employeeName = $employee ? $employee->surname . ' ' . $employee->name . ' ' . $employee->patronymic : '';

            return [
                'id' => $compound->id,
                'quantity' => $compound->quantity,
                'total_price' => $compound->total_price,
                'order_id' => $compound->order_id,
                'product_id' => $compound->product_id,
                'status_order' => $compound->orders->status_orders->name,
                'product' => $compound->products->name,
                'user' => $compound->orders->users->surname . ' '. $compound->orders->users->name. ' '. $compound->orders->users->patronymic,
                'employee' => $employeeName,
            ];
        });

        return response()->json(['data' => $compounds])->setStatusCode(200);
    }


    // Просмотр конкретного заказа
    public function show(int $order_id)
    {
        // Находим заказ по order_id
        $order = Order::find($order_id);
        if (!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        $compounds = Compound::with('orders.status_orders', 'products', 'orders.employees', 'orders.users')->where('order_id', $order_id)->get();

        // Преобразуем коллекцию, чтобы включить имена статусов заказов и имена продуктов
        $compounds = $compounds->map(function ($compound) {
            $employee = $compound->orders->employees;
            $employeeName = $employee ? $employee->surname . ' ' . $employee->name . ' ' . $employee->patronymic : '';

            return [
                'id' => $compound->id,
                'quantity' => $compound->quantity,
                'total_price' => $compound->total_price,
                'order_id' => $compound->order_id,
                'product_id' => $compound->product_id,
                'status_order' => $compound->orders->status_orders->name,
                'product' => $compound->products->name,
                'user' => $compound->orders->users->surname . ' '. $compound->orders->users->name. ' '. $compound->orders->users->patronymic,
                'employee' => $employeeName,
            ];
        });

        $compound = Compound::with('orders')->where('order_id', $order_id)->get();
        if (!$compound) {
            throw new ApiException(404, 'Не найдено');
        }
        return response()->json(['data' => $compounds])->setStatusCode(200);
    }

    // Просмотр всех заказов по конкретному товару и общей выручки за всё время, а также количеством заказов для данного товара и количество купленного товара
    public function showProduct(int $id)
    {
        $compounds = Compound::with('orders')->where('product_id', $id)->get();
        $total_money = 0;
        $countProduct = 0;
        $countOrder = 0;
        $orderIds = [];
        foreach ($compounds as $compound) {
            if (!in_array($compound->order_id, $orderIds)) {
                $orderIds[] = $compound->order_id;
                $countOrder++;
            }
            $total_money += $compound->total_price;
            $countProduct += $compound->quantity;
        }
        return response()->json([
            'data'=>$compounds,
            'total_money' => $total_money,
            'order_count'=>$countOrder,
            'product_count'=>$countProduct
        ]);
    }
    // Просмотр всех заказов и общей выручки за конкретный ГГГГ.ММ.ДД
    public function dateOrder(Request $request)
    {
        // Получаем заказы для переданной даты
        $date = $request->input('date_order');
        $orders = Order::whereDate('date_order', $date)->get();

        // Выбираем только идентификаторы заказов
        $orderIds = $orders->pluck('id');

        // Получаем все связанные с заказами объекты Compound
        $compounds = Compound::with('orders')->whereHas('orders', function ($query) use ($orderIds) {
            $query->whereIn('id', $orderIds);
        })->get();
        $total_money = 0;
        foreach ($compounds as $compound) {
            $total_money += $compound->total_price;
        }
        return response()->json([
            'data' => $compounds,
            'total_money'=>$total_money
        ])->setStatusCode(200);
    }
    // Просмотр всех заказов и общей выручки за период от ГГГГ.ММ.ДД до ГГГГ.ММ.ДД
    public function betweenDate(Request $request)
    {
        // Получаем начальную и конечную даты из запроса
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        // Конвертируем даты в формат datetime
        $start_datetime = Carbon::parse($date_start)->startOfDay();
        $end_datetime = Carbon::parse($date_end)->endOfDay();
        // Выполняем запрос на выборку всех заказов за указанный период
        $orders = Order::whereBetween('date_order', [$start_datetime, $end_datetime])->get();
        // Выбираем только идентификаторы заказов
        $orderIds = $orders->pluck('id');
        // Получаем все связанные с заказами объекты Compound
        $compounds = Compound::with('orders')->whereHas('orders', function ($query) use ($orderIds) {
            $query->whereIn('id', $orderIds);
        })->get();
        $total_money = 0;
        foreach ($compounds as $compound) {
            $total_money += $compound->total_price;
        }
        // Возвращаем данные о заказах и общей выручке
        return response()->json([
            'data' => $compounds,
            'total_money' => $total_money,
        ])->setStatusCode(200);
    }
    // Просмотр всех заказов по конкретному товару и общей выручки за период ГГГГ.ММ.ДД до ГГГГ.ММ.ДД, а также количеством заказов для данного товара и количество купленного товара
    public function productBetweenDate(Request $request, int $id)
    {
        // Получаем начальную и конечную даты из запроса
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        // Конвертируем даты в формат datetime
        $start_datetime = Carbon::parse($date_start)->startOfDay();
        $end_datetime = Carbon::parse($date_end)->endOfDay();
        // Выполняем запрос на выборку всех заказов за указанный период
        $orders = Order::whereBetween('date_order', [$start_datetime, $end_datetime])->get();
        // Выбираем только идентификаторы заказов
        $orderIds = $orders->pluck('id');
        // Получаем все связанные с заказами объекты Compound
        $compounds = Compound::with('orders')->where('product_id', $id)->whereHas('orders', function ($query) use ($orderIds) {
            $query->whereIn('id', $orderIds);
        })->get();
        $total_money = 0;
        $countProduct = 0;
        $countOrder = 0;
        $orderIds = [];
        foreach ($compounds as $compound) {
            if (!in_array($compound->order_id, $orderIds)) {
                $orderIds[] = $compound->order_id;
                $countOrder++;
            }
            $total_money += $compound->total_price;
            $countProduct += $compound->quantity;
        }
        return response()->json([
            'data'=>$compounds,
            'total_money' => $total_money,
            'order_count'=>$countOrder,
            'product_count'=>$countProduct
        ])->setStatusCode(200);
    }
}
