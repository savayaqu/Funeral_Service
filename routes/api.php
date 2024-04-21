<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\NewsController;

                        //Хз по ролям

// Просмотр всех пользователей
Route::get('/users', [UserController::class, 'index']);

// Просмотр всех заказов
Route::get('/orders', [OrderController::class, 'index']);
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
Route::get('/product/{id}/review', [ReviewController::class, 'index']);
//Просмотр всех новостей
Route::get('/news', [NewsController::class, 'index']);
//Просмотр конкретной новости
Route::get('/news/{id}', [NewsController::class, 'show']);

            // Функционал авторизированного пользователя
Route::middleware('auth:api')->group(function () {
    //Выход
    Route::get('/logout', [AuthController::class, 'logout']);
    //Просмотр профиля
    Route::get('/profile', [UserController::class, 'this']);
    //Изменнеие пароля в профиле
    Route::patch('/profile', [UserController::class, 'changePass']);
});

            // Функционал клиента
Route::middleware('auth:api', 'role:user')->group(function () {
    //Добавление товара в корзину
    Route::post('/product/{id}', [CartController::class, 'addToCart']);
    //Просмотр своей корзины
    Route::get('/cart', [CartController::class, 'index']);
    //Оформление заказа
    Route::post('/checkout', [OrderController::class, 'checkout']);
    //Оставление отзыва для товара
    Route::post('/product/{id}/review', [ReviewController::class, 'store']);
    //Редактирование своей корзины
    Route::patch('/cart', [CartController::class, 'update']);
    //Удалеления товара из корзины
    Route::delete('/cart/product/{id}', [CartController::class, 'delete']);
    //Просмотр всех заказов текущего пользователя
    Route::get('/orders', [OrderController::class, 'index']);

});

            // Функционал менеджера
Route::middleware('auth:api', 'role:manager')->group(function () {

});

            // Функционал сотрудника
Route::middleware('auth:api', 'role:employee')->group(function () {
    //
});

            // Функционал администратора
Route::middleware('auth:api', 'role:admin')->group(function () {
    // CRUD новости
    // CRUD товары
    // CRUD категории
    // CRUD пользователи
    // CRUD смены
    // CRUD отзывы
    // CRUD
});
