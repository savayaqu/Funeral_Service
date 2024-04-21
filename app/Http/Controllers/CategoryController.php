<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //Метод просмотра категорий
    public function index()
    {
        $categories = Category::all();
        if(!$categories) {
            throw new ApiException(404, 'Не найдено');
        } else {
            return response([
                'data' => $categories
            ]);
        }
    }
}
