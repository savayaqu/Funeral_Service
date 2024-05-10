<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\NewsController;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\ShiftController;
use \App\Http\Controllers\CompoundController;
use \App\Http\Controllers\RoleController;
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
Route::get('/product/{id}/reviews', [ReviewController::class, 'show']);
// Просмотр всех отзывов
Route::get('/reviews', [ReviewController::class, 'index']);
//Просмотр всех новостей
Route::get('/news', [NewsController::class, 'index']);
//Просмотр конкретной новости
Route::get('/news/{id}', [NewsController::class, 'show']);
//Просмотр всех фотографий товаров
Route::get('/photo/products', [ProductController::class, 'indexPhoto']);
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
    Route::post('/profile/update', [UserController::class, 'changePass']);
    //Добавление товара в корзину
    Route::post('/cart/product/{id}', [CartController::class, 'addToCart']);
    //Просмотр своей корзины
    Route::get('/cart', [CartController::class, 'index']);
    //Оформление заказа
    Route::post('/checkout', [OrderController::class, 'checkout']);
    //Редактирование своей корзины
    Route::post('/cart/update', [CartController::class, 'update']);
    //Удалеления товара из корзины
    Route::delete('/cart/product/{id}', [CartController::class, 'delete']);
    //Просмотр всех заказов текущего пользователя
    Route::get('/orders', [OrderController::class, 'index']);
    //Создание отзыва для купленного товара
    Route::post('/product/{id}/review/create', [ReviewController::class, 'createReview']);
});
            // Функционал менеджера
Route::middleware('auth:api', 'role:manager,admin')->group(function () {
    // Просмотр всех пользователей
    Route::get('/users', [UserController::class, 'index']);
    //Просмотр сотрудников
    Route::get('/employees', [UserController::class, 'employees']);
    //Просмотр конкретного пользователя
    Route::get('/user/{id}', [UserController::class, 'show']);
    // Создание смены
    Route::post('/shift/create', [ShiftController::class, 'createShift']);
    // Редактирование смены
    Route::post('/shift/{id}/update', [ShiftController::class, 'updateShift']);
    // Удаление сотрудника со смены
    Route::delete('/shift/{id}/user/delete', [ShiftController::class, 'deleteUser']);
    // Добавление сотрудника на смену
    Route::post('/shift/{id}/user/add', [ShiftController::class, 'addUser']);
});

            // Функционал сотрудника
Route::middleware('auth:api', 'role:employee,manager,admin')->group(function () {
    // Просмотр смен
    Route::get('/shifts', [ShiftController::class, 'index']);
    // Просмотр конкретной смены
    Route::get('/shift/{id}', [ShiftController::class, 'show']);
    //Прикрепление к заказу
    Route::post('/order/{id}/employee/attach', [OrderController::class, 'attach']);
    //Открепление от заказа
    Route::post('/order/{id}/employee/detach', [OrderController::class, 'detach']);
});

            // Функционал администратора
Route::middleware('auth:api', 'role:admin')->group(function () {
             //CRUD NEWS
    // Создание новости
    Route::post('/news/create', [NewsController::class, 'createNews']);
    // Редактирвание новости
    Route::post('/news/{id}/update', [NewsController::class, 'updateNews']);
    // Удаление новости
    Route::delete('/news/{id}/delete', [NewsController::class, 'deleteNews']);
            //CRUD PRODUCTS
   //Создание товара
    Route::post('/product/create', [ProductController::class, 'create']);
    //Редактирование товара
    Route::post('/product/{id}/update', [ProductController::class, 'update']);
    //Удаление товара
    Route::delete('/product/{id}/delete', [ProductController::class, 'delete']);
            //CRUD ROLES
    // Просмотр ролей
    Route::get('/roles', [RoleController::class, 'index']);
    // Создание роли
    Route::post('/role/create', [RoleController::class, 'createRole']);
    // Редактирование роли
    Route::post('/role/{id}/update', [RoleController::class, 'updateRole']);
    // Удаление роли
    Route::delete('/role/{id}/delete', [RoleController::class, 'deleteRole']);
            //CRUD SHIFTS
    // Удаление смены
    Route::delete('/shift/{id}/delete', [ShiftController::class, 'deleteShift']);
            //CRUD USERS
    //Создание нового пользователя с присвоением роли
    Route::post('/user/create', [AdminController::class, 'createUser']);
    //Редактирование пользователя
    Route::post('/user/{id}/update', [AdminController::class, 'updateUser']);
    //Удаление пользователя
    Route::delete('/user/{id}/delete', [AdminController::class, 'deleteUser']);
            //CRUD REVIEWS
    //Редактирование отзыва
    Route::post('/review/{id}/update', [AdminController::class, 'updateReview']);
    //Удаление отзыва
    Route::delete('/review/{id}/delete', [AdminController::class, 'deleteReview']);
            //CRUD категорий
    //Создание категории
    Route::post('/category/create'       , [AdminController::class, 'createCategory']);
    //Обновление категории
    Route::post('/category/{id}/update' , [AdminController::class, 'updateCategory']);
    //Удаление категории
    Route::delete('/category/{id}/delete', [AdminController::class, 'deleteCategory']);
            //CRUD статусов заказов
    //Создание статуса заказа
    Route::post('/status_order/create'       , [AdminController::class, 'createStatusOrders']);
    //Обновление статуса заказа
    Route::post('/status_order/{id}/update' , [AdminController::class, 'updateStatusOrders']);
    //Удаление статуса заказа
    Route::delete('/status_order/{id}/delete', [AdminController::class, 'deleteStatusOrders']);
            //CRUD PAYMENTS
    //Редактирование способов оплаты
    Route::post('/payment/{id}/update', [AdminController::class, 'updatePayment']);
    //Создание способа оплаты
    Route::post('/payment/create', [AdminController::class, 'createPayment']);
    //Удаление способа оплаты
    Route::delete('/payment/{id}/delete', [AdminController::class, 'deletePayment']);
            //CRUD ORDERS
    //Просмотр заказа
    Route::get('/order/{id}', [OrderController::class, 'show']);
    //Редактирование заказа
    Route::post('/order/{id}/update', [OrderController::class, 'update']);
    //Удаление заказа
    Route::delete('/order/{id}/delete', [AdminController::class, 'deleteOrder']);
            //CRUD COMPOUND
    //Просмотр состава заказа по id заказа
    Route::get('/compounds/order/{id}', [CompoundController::class, 'show']);
    //Просмотр состава заказа
    Route::get('/order/compound/{id}', [OrderController::class, 'showCompound']);
    //Создание состава заказа
    Route::post('/order/{id}/compound/create', [OrderController::class, 'create']);
    //Обновление состава заказа
    Route::post('/order/compound/{id}/update', [AdminController::class, 'updateCompound']);
    //Удаление товара из состава заказа
    Route::delete('/order/compound/{id}/delete', [AdminController::class, 'deleteCompound']);
            //CRUD ОТЧЁТЫ
// Выручка товара за всё время
    Route::get('/orders/product/{id}', [OrderController::class, 'showProduct']);
// Выручка заказов за период
    Route::post('/orders/between', [OrderController::class, 'betweenDate']);
// Выпручка товара за период
    Route::post('/orders/product/{id}/between', [OrderController::class, 'productBetweenDate']);
// Выручка категории за период
    Route::post('/orders/category/{id}/between', [OrderController::class, 'categoryBetweenDate']);
    // Просмотр корзины другого пользователя
    Route::get('/user/{id}/cart', [CartController::class, 'show']);
});
