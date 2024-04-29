<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\AdminCreatePaymentRequest;
use App\Http\Requests\AdminCreateReviewRequest;
use App\Http\Requests\AdminCreateUserRequest;
use App\Http\Requests\AdminUpdateOrderRequest;
use App\Http\Requests\AdminUpdatePaymentRequest;
use App\Http\Requests\AdminUpdateReviewRequest;
use App\Http\Requests\AdminUpdateUserRequest;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Category;
use App\Models\Compound;
use App\Models\News;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function deleteCompound(int $compoundId) {
        $compound = Compound::where('id', $compoundId)->first();
        if(!$compound) {
            throw new ApiException(404, 'Не найдено');
        }
        $compound->delete();
        return response()->json(['message' => 'Состав заказа '. $compoundId .' удалён'])->setStatusCode(200);
    }
    public function updateCompound(AdminUpdateOrderRequest $request, int $compoundId)
    {
        $compound = Compound::with('products')->where('id', $compoundId)->first();
        if(!$compound) {
            throw new ApiException(404, 'Не найдено');
        }
        if ($request->input('quantity')) {
            $quantity = $request->input('quantity');
            $compound->quantity = $quantity;
            $compound->save();
        } else {
            $quantity = $compound->quantity;
        }

        if ($request->input('product_id')) {
            $compound->product_id = $request->input('product_id');
            $compound->save();
        }

        $product = Product::where('id', $compound->product_id)->first();
        $name = $compound->products->name;
        $compound->total_price = $quantity * $product->price;
        $compound->save();
        $response = [
            'id' => $compoundId,
            'quantity' => $compound->quantity,
            'total_price' => $compound->total_price,
            'order_id' =>$compound->product_id,
            'product_id' => $compound->product_id,
            'product_name' => $name,
        ];
        return response()->json(['data' => $response])->setStatusCode(200);
    }


    public function deleteOrder(int $orderId)
    {
        $compound = Compound::where('order_id', $orderId)->get();
        if($compound->isEmpty()) {
            throw new ApiException(404, 'Не найдено');
        }

        $order = Order::where('id', $orderId)->first();
        if(!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        $compound->each->delete(); // Удалить каждый элемент коллекции
        $order->delete();

        return response()->json(['message' =>'Удалено'])->setStatusCode(200);
    }

    public function createStatusOrders(AdminCreatePaymentRequest $request)
    {
        $statusOrders = new Category($request->all());
        $statusOrders->save();
        return response()->json(['message' => 'Статус заказа успешно сохранён'])->setStatusCode(201);
    }
    public function updateStatusOrders(AdminUpdatePaymentRequest $request, int $statusOrderId)
    {
        $statusOrders = Category::where('id', $statusOrderId)->first();
        if(!$statusOrders) {
            throw new ApiException(404, 'Не найдено');
        }
        $statusOrders->fill($request->all());
        $statusOrders->save();
        return response()->json(['message' => 'Статус заказа ' .$statusOrderId. ' обновлён'])->setStatusCode(200);
    }
    public function deleteStatusOrders(int $statusOrderId)
    {
        $statusOrders = Category::where('id', $statusOrderId)->first();
        if(!$statusOrders) {
            throw new ApiException(404, 'Не найдено');
        }
        $statusOrders->delete();
        return response()->json(['message' => 'Статус заказа ' .$statusOrderId. ' удалён'])->setStatusCode(200);
    }
    public function createCategory(AdminCreatePaymentRequest $request)
    {
        $category = new Category($request->all());
        $category->save();
        return response()->json(['message' => 'Категория успешно сохранена'])->setStatusCode(201);
    }
    public function updateCategory(AdminUpdatePaymentRequest $request, int $categoryId)
    {
        $category = Category::where('id', $categoryId)->first();
        if(!$category) {
            throw new ApiException(404, 'Не найдено');
        }
        $category->fill($request->all());
        $category->save();
        return response()->json(['message' => 'Категория ' .$categoryId. ' обновлена'])->setStatusCode(200);
    }
    public function deleteCategory(int $categoryId)
    {
        $category = Category::where('id', $categoryId)->first();
        if(!$category) {
            throw new ApiException(404, 'Не найдено');
        }
        $category->delete();
        return response()->json(['message' => 'Категория ' .$categoryId. ' удалён'])->setStatusCode(200);
    }



    public function createPayment(AdminCreatePaymentRequest $request)
    {
        $payment = new Payment($request->all());
        $payment->save();
        return response()->json(['message' => 'Способ оплаты успешно сохранен'])->setStatusCode(201);
    }
    public function updatePayment(AdminUpdatePaymentRequest $request, int $paymentId)
    {
        $payment = Payment::where('id', $paymentId)->first();
        if(!$payment) {
            throw new ApiException(404, 'Не найдено');
        }
        $payment->fill($request->all());
        $payment->save();
        return response()->json(['message' => 'Способ оплаты ' .$paymentId. ' обновлён'])->setStatusCode(200);
    }
    public function deletePayment(int $paymentId)
    {
        $payment = Payment::where('id', $paymentId)->first();
        if(!$payment) {
            throw new ApiException(404, 'Не найдено');
        }
        $payment->delete();
        return response()->json(['message' => 'Способ оплаты ' .$paymentId. ' удалён'])->setStatusCode(200);
    }
    public function deleteReview(int $id)
    {
        $review = Review::where('id', $id)->first();
        if(!$review) {
            throw new ApiException(404, 'Не найдено');
        }
        $review->delete();
        return response()->json(['message' => 'Отзыв ' .$id. ' удалён'])->setStatusCode(200);
    }
    public function updateReview(AdminUpdateReviewRequest $request, int $reviewId)
    {
        $review = Review::where('id', $reviewId)->first();
        if(!$review) {
            throw new ApiException(404, 'Не найдено');
        }
        $review->fill($request->all());
        $review->save();
        return response()->json(['message' => 'Отзыв ' .$reviewId. ' обновлён'])->setStatusCode(200);
    }
    public function createReview(AdminCreateReviewRequest $request) {
        $review = new Review($request->all());
        $review->save();
        return response()->json(['message' => 'Отзыв успешно сохранен'])->setStatusCode(201);
    }
    public function createNews(CreateNewsRequest $request) {
        $news = new News($request->all());
        $news->save();
        return response()->json(['message' => 'Новость создана'])->setStatusCode(201);
    }
    public function updateNews(UpdateNewsRequest $request, int $id) {
        $news = News::where('id', $id)->first();
        if(!$news) {
            throw new ApiException(404, 'Не найдено');
        }
        $news->fill($request->all());
        $news->save();
        return response()->json(['message'=> 'Новость '. $id .' обновлена'])->setStatusCode(200);
    }
    public function deleteNews(int $id) {
        $news = News::where('id', $id)->first();
        if(!$news) {
            throw new ApiException(404, 'Не найдено');
        }
        $news->delete();
        return response()->json(['message'=> 'Новость '. $id .' удалена'])->setStatusCode(200);
    }
    public function createUser(AdminCreateUserRequest $request) {
        $user = new User($request->all());
        $user->save();
        return response()->json()->setStatusCode(201);
    }
    public function updateUser(AdminUpdateUserRequest $request, int $id) {
        $user = User::where('id', $id)->first();
        if (!$user) {
            throw new ApiException(404, 'Не найдено');
        }
        $user->fill($request->all());
        $user->save();
        return response()->json(['message' => 'Пользователь ' . $id.' обновлён'])->setStatusCode(200);
    }
    public function deleteUser(int $id) {
        $user = User::where('id', $id)->first();
        if (!$user) {
            throw new ApiException(404, 'Не найдено');
        }
        $user->delete();
        return response()->json(['message' => 'Пользователь ' . $id.' удалён'])->setStatusCode(200);
    }
    public function createRole(CreateRoleRequest $request) {
        $role = new Role($request->all());
        $role->save();
        return response()->json('Роль создана')->setStatusCode(201);
    }
    public function updateRole(UpdateRoleRequest $request, int $id) {
        $role = Role::where('id', $id)->first();
        $role->fill($request->all());
        $role->save();
        return response()->json('Роль '.$id. ' обновлена')->setStatusCode(200);
    }
    public function deleteRole(int $id) {
        $role = Role::where('id', $id)->first();
        $role->delete();
        return response()->json('Роль '.$id. ' удалена')->setStatusCode(200);
    }
}
