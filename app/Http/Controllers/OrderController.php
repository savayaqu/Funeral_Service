<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\AddEmployeeOrderRequest;
use App\Http\Requests\BetweenDateOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\DateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\CompoundsResource;
use App\Models\Cart;
use App\Models\Compound;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\StatusOrder;
use Carbon\Carbon;
use \App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //Просмотр состава заказа
    public function showCompound(int $compoundId) {
        $compound = Compound::where('id', $compoundId)->first();
        if(!$compound) {
            throw new ApiException(404, 'Не найдено');
        }
        return response()->json(['data' => $compound])->setStatusCode(200);
    }
    //Обновление заказа
    public function update(UpdateOrderRequest $request, int $orderId) {
        $order = Order::where('id', $orderId)->first();
        if(!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        $order->fill($request->all());
        $order->save();
        return response()->json(['message' => 'Заказ '.$orderId. ' обновлён'])->setStatusCode(200);
    }
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
        $userMe = auth()->user();
        $user = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('code', 'user');
        })->where('id', $userMe->id)->first();
        $userEmployee = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('code', 'user');
        })->where('id', $userMe->id)->first();
        if($user || $userEmployee) {
            $orders = Order::with('status_orders', 'employees', 'users')->where('user_id', $user->id)->get();
            $orders = $orders->map(function ($order) {
                $employee = $order->employees;
                $employeeName = $employee ? $employee->surname . ' ' . $employee->name . ' ' . $employee->patronymic : '';
                return [
                    'id' => $order->id,
                    'date_order' => $order->date_order,
                    'payment_id' => $order->payment_id,
                    'user_id' => $order->user_id,
                    'user' => $order->users->surname . ' '. $order->users->name. ' '. $order->users->patronymic,
                    'employee' => $employeeName,
                    'status_order' => $order->status_orders->name
                ];
            });
            return response()->json(['data' => $orders]);
        }
        else
        {
            $orders = Order::with('status_orders', 'employees', 'users')->get();
            $orders = $orders->map(function ($order) {
                $employee = $order->employees;
                $employeeName = $employee ? $employee->surname . ' ' . $employee->name . ' ' . $employee->patronymic : '';
               return [
                   'id' => $order->id,
                   'date_order' => $order->date_order,
                   'payment_id' => $order->payment_id,
                   'user_id' => $order->user_id,
                   'user' => $order->users->surname . ' '. $order->users->name. ' '. $order->users->patronymic,
                   'employee' => $employeeName,
                   'status_order' => $order->status_orders->name
               ];
            });
            return response()->json(['data' => $orders])->setStatusCode(200);
        }
    }

    // Просмотр конкретного заказа
    public function show(int $order_id)
    {
        $order = Order::with('status_orders', 'employees', 'users')->where('id', $order_id)->first();
        if(!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        $employee = $order->employees;
        $employeeName = $employee ? $employee->surname . ' ' . $employee->name . ' ' . $employee->patronymic : '';
        $responseData = [
            'id' => $order->id,
            'date_order' => $order->date_order,
            'payment_id' => $order->payment_id,
            'user_id' => $order->user_id,
            'user' => $order->users->surname . ' '. $order->users->name. ' '. $order->users->patronymic,
            'products' => CompoundsResource::collection($order->compounds),
            'employee' => $employeeName,
            'status_order' => $order->status_orders->name
        ];
        return response()->json(['data' => $responseData])->setStatusCode(200);
    }
        //Просмотр всех заказов по конкретному товару и общей выручки за всё время, а также количеством заказов для данного товара и количество купленного товара
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
    public function dateOrder(DateOrderRequest $request)
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
    public function betweenDate(BetweenDateOrderRequest $request)
    {
        // Получаем начальную и конечную даты из запроса
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        // Конвертируем даты в формат datetime
        $start_datetime = Carbon::parse($date_start)->startOfDay();
        $end_datetime = Carbon::parse($date_end)->endOfDay();
        // Выполняем запрос на выборку всех заказов за указанный период
        $orders = Order::with('compounds')->whereBetween('date_order', [$start_datetime, $end_datetime])->get();

        $total_money = 0;
        $countOrder = 0;

        $formattedOrders = [];

        foreach ($orders as $order) {
            $orderData = [
                'id' => $order->id,
                'date_order' => $order->date_order,
                'payment_id' => $order->payment_id,
                'user_id' => $order->user_id,
                'user' => $order->users->surname . ' '. $order->users->name. ' '. $order->users->patronymic,
                'employee' => $order->employees ? $order->employees->surname . ' ' . $order->employees->name . ' ' . $order->employees->patronymic : '',
                'status_order' => $order->status_orders->name,
                'compounds' => $order->compounds->map(function ($compound) {
                    return [
                        'id' => $compound->id,
                        'order_id' => $compound->order_id,
                        'quantity' => $compound->quantity,
                        'total_price' => $compound->total_price,
                        'product_id' => $compound->product_id,
                        'product' => [
                            'id' => $compound->products->id,
                            'name' => $compound->products->name,
                        ],
                    ];
                }),
            ];

            $total_money += $order->compounds->sum('total_price');
            $countOrder++;

            $formattedOrders[] = $orderData;
        }

        // Возвращаем данные о заказах и общей выручке
        return response()->json([
            'data' => $formattedOrders,
            'total_money' => $total_money,
            'count_order' => $countOrder,
        ])->setStatusCode(200);
    }

    // Просмотр всех заказов по конкретному товару и общей выручки за период ГГГГ.ММ.ДД до ГГГГ.ММ.ДД, а также количеством заказов для данного товара и количество купленного товара
    public function productBetweenDate(BetweenDateOrderRequest $request, int $id)
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
        if(!$compounds) {
            throw new ApiException(404, 'Не найдено');
        }
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
