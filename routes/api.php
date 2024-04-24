<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\NewsController;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\ShiftController;
             // Функционал пользователя
//Регистрация
Route::post('/register', [UserController::class, 'create']);
//Авторизация
Route::post('/login', [AuthController::class, 'login' ]);
//Просмотр категорий товаров
Route::get('/categories', [CategoryController::class, 'index']);
//Просмотр товаров определенной категории
Route::get('/category/{id}', [ProductController::class, 'showMany']);
//Просмотр конкретного товара
Route::get('/product/{id}', [ProductController::class, 'show']);
//Просмотр всех товаров
Route::get('/products', [ProductController::class, 'index']);
//Просмотр отзывов у товара
Route::get('/product/{id}/review', [ReviewController::class, 'show']);
// Просмотр всех отзывов
Route::get('/reviews', [ReviewController::class, 'index']);
//Просмотр всех новостей
Route::get('/news', [NewsController::class, 'index']);
//Просмотр конкретной новости
Route::get('/news/{id}', [NewsController::class, 'show']);
//Просмотр всех фото конкретной новости
Route::get('/photo/news/{id}', [NewsController::class, 'showPhotos']);
//Просмотр всех фото конкретного товара
Route::get('/photo/product/{id}', [ProductController::class, 'showPhotos']);
//Просмотр способов оплаты
Route::get('/payments', [UserController::class, 'payments']);
//Просмотр статусов заказов
Route::get('/status_orders', [UserController::class, 'statusOrders']);

            // Функционал авторизированного пользователя
Route::middleware('auth:api')->group(function () {
    //Выход
    Route::get('/logout', [AuthController::class, 'logout']);
    //Просмотр профиля
    Route::get('/profile', [UserController::class, 'this']);
    //Изменение пароля в профиле
    Route::patch('/profile', [UserController::class, 'changePass']);
    //Добавление товара в корзину
    Route::post('/cart/product/{id}', [CartController::class, 'addToCart']);
    //Просмотр своей корзины
    Route::get('/cart', [CartController::class, 'index']);
    //Оформление заказа
    Route::post('/checkout', [OrderController::class, 'checkout']);
    //Редактирование своей корзины
    Route::patch('/cart', [CartController::class, 'update']);
    //Удалеления товара из корзины
    Route::delete('/cart/product/{id}', [CartController::class, 'delete']);
    //Просмотр всех заказов текущего пользователя
    Route::get('/orders', [OrderController::class, 'index']);
    //Создание отзыва для купленного товара
    Route::post('/review/product/{id}/create', [ReviewController::class, 'createReview']);

});
            // Функционал менеджера
Route::middleware('auth:api', 'role:manager')->group(function () {
    // Просмотр всех пользователей
    Route::get('/users', [UserController::class, 'index']);
    //Добавление сотрудника на смену
    Route::post('/shift/{id}/user/add', [ShiftController::class, 'addUser']);
    //Просмотр конкретного пользователя
    Route::get('/user/{id}', [UserController::class, 'show']);
    // Удаление сотрудника со смены
    Route::delete('/shift/{id}/user/add', [ShiftController::class, 'deleteUser']);
    // Просмотр смен
    Route::get('/shifts', [ShiftController::class, 'index']);
    // Просмотр конкретной смены
    Route::get('/shift/{id}', [ShiftController::class, 'show']);
    // Создание смены
    Route::post('/shift/create', [ShiftController::class, 'createShift']);
    // Редактирование смены
    Route::patch('/shift/{id}/update', [ShiftController::class, 'updateShift']);
    //Просмотр конкретного пользователя
    Route::get('/user/{id}', [UserController::class, 'show']);
});

            // Функционал сотрудника
Route::middleware('auth:api', 'role:employee')->group(function () {
    // Просмотр смен
    Route::get('/shifts', [ShiftController::class, 'index']);
    // Просмотр конкретной смены
    //Прикрепление к заказу
    Route::patch('/order/{id}/employee/attach', [EmployeeController::class, 'attach']);
    //Открепление от заказа
    Route::patch('/order/{id}/employee/detach', [EmployeeController::class, 'detach']);
});

            // Функционал администратора
Route::middleware('auth:api', 'role:admin')->group(function () {
    //Создание нового пользователя с присвоением роли
    Route::post('/user/create', [AdminController::class, 'createUser']);
    //Редактирование пользователя
    Route::patch('/user/{id}/update', [AdminController::class, 'updateUser']);
    //Удаление пользователя
    Route::delete('/user/{id}/delete', [AdminController::class, 'deleteUser']);
    //Добавление сотрудника на смену
    Route::post('/shift/{id}/user/add', [ShiftController::class, 'addUser']);
    // Удаление сотрудника со смены
    Route::delete('/shift/{id}/user/add', [ShiftController::class, 'deleteUser']);
    // Создание смены
    Route::post('/shift/create', [ShiftController::class, 'createShift']);
    // Редактирование смены
    Route::patch('/shift/{id}/update', [ShiftController::class, 'updateShift']);
    // Удаление смены
    Route::delete('/shift/{id}/delete', [ShiftController::class, 'deleteShift']);
    // Просмотр смен
    Route::get('/shifts', [ShiftController::class, 'index']);
    // Просмотр конкретной смены
    Route::get('/shift/{id}', [ShiftController::class, 'show']);
    //Просмотр конкретного пользователя
    Route::get('/user/{id}', [UserController::class, 'show']);
    // Просмотр всех пользователей
    Route::get('/users', [UserController::class, 'index']);
    // Создание роли
    Route::post('/role/create', [AdminController::class, 'createRole']);
    // Редактирование роли
    Route::patch('/role/{id}/update', [AdminController::class, 'updateRole']);
    // Удаление роли
    Route::delete('/role/{id}/delete', [AdminController::class, 'deleteRole']);
    // Создание новости
    Route::post('/news/create', [AdminController::class, 'createNews']);
    // Редактирвание новости
    Route::patch('/news/{id}/update', [AdminController::class, 'updateNews']);
    // Удаление новости
    Route::delete('/news/{id}/delete', [AdminController::class, 'deleteNews']);
    // Добавление фото к новостям
    Route::post('/photo/news/create', [NewsController::class, 'createPhoto']);
    //Редактирование фото новости
    Route::post('/photo/{id}/news/update', [NewsController::class, 'updatePhoto']);
    //Удаление фото новости
    Route::delete('/photo/{id}/news/delete', [NewsController::class, 'deletePhoto']);
    // Добавление фото к товарам
    Route::post('/photo/product/create', [ProductController::class, 'createPhoto']);
    //Редактирование фото товара
    Route::post('/photo/{id}/product/update', [ProductController::class, 'updatePhoto']);
    //Удаление фото товара
    Route::delete('/photo/{id}/product/delete', [ProductController::class, 'deletePhoto']);
    //Создание отзыва
    Route::post('/review/create', [AdminController::class, 'createReview']);
    //Редактирование отзыва
    Route::patch('/review/{id}/update', [AdminController::class, 'updateReview']);
    //Удаление отзыва
    Route::delete('/review/{id}/delete', [AdminController::class, 'deleteReview']);
    //Прикрепление сотрудника к заказу
    Route::post('/order/{id}/employee', [OrderController::class, 'addEmployee']);
    //Редактирование способов оплаты
    Route::patch('/payment/{id}/update', [AdminController::class, 'updatePayment']);
    //Создание способа оплаты
    Route::post('/payment/create', [AdminController::class, 'createPayment']);
    //Удаление способа оплаты
    Route::delete('/payment/{id}/delete', [AdminController::class, 'deletePayment']);
    //CUD категорий
    Route::post('/category/create'       , [AdminController::class, 'createCategory']);
    Route::patch('/category/{id}/update' , [AdminController::class, 'updateCategory']);
    Route::delete('/category/{id}/delete', [AdminController::class, 'deleteCategory']);
    //CUD статусов заказов
    Route::post('/status_orders/create'       , [AdminController::class, 'createStatusOrders']);
    Route::patch('/status_orders/{id}/update' , [AdminController::class, 'updateStatusOrders']);
    Route::delete('/status_orders/{id}/delete', [AdminController::class, 'deleteStatusOrders']);
    //Редактирование заказа
    Route::patch('/order/{id}/update', [AdminController::class, 'updateOrder']);
    //Удаление заказа
    Route::delete('/order{id}/delete', [AdminController::class, 'deleteOrder']);

// Просмотр конкретного заказа
    Route::get('/order/{id}', [OrderController::class, 'show']);
// Просмотр всех заказов по конкретному товару и общей выручки за всё время, а также количеством заказов для данного товара и количество купленного товара
    Route::get('/orders/product/{id}', [OrderController::class, 'showProduct']);
// Просмотр всех заказов и общей выручки, заказов за конкретный ГГГГ.ММ.ДД
    Route::post('/orders', [OrderController::class, 'dateOrder']);
// Просмотр всех заказов и общей выручки за период от ГГГГ.ММ.ДД до ГГГГ.ММ.ДД
    Route::post('/orders/between', [OrderController::class, 'betweenDate']);
// Просмотр всех заказов по конкретному товару и общей выручки за период ГГГГ.ММ.ДД до ГГГГ.ММ.ДД, а также количеством заказов для данного товара и количество купленного товара
    Route::post('/orders/product/{id}/between', [OrderController::class, 'productBetweenDate']);
});
