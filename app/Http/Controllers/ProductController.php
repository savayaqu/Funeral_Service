<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //Метод просмотра товаров конкретной категории
    public function showMany(int $id) {
        $products = Product::where('category_id', $id)->get();
        if($products->isEmpty()) {
            throw new ApiException(404, 'Не найдено');
        }
        return response([
            'data' => $products
        ]);
    }
    //Метод просмотра всех товаров
    public function index() {
        $products = Product::all();
        if($products->isEmpty()) {
            throw new ApiException(404, 'Не найдено');
        } else {
            return response([
                'data' => $products,
            ]);
        }
    }
    //Метод просмотра конкретного товара
    public function show(int $id) {
        $product = Product::where('id', $id)->first();
        if(!$product) throw new ApiException(404, 'Не найдено');
        return response([
            'data' => $product
        ]);
    }
}
