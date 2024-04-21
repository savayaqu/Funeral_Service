<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //Метод просмотра всех новостей
    public function index() {
        $news = News::all();
        if($news->isEmpty()) {
            throw new ApiException(404, 'Новости не найдены');
        } else {
            return response([
                'data' => $news,
            ]);
        }
    }
    //Метод просмотра конкретной новости
    public function show(int $id) {
        $news = News::where('id', $id)->first();
        if(!$news) throw new ApiException(404, 'Новость не найдена');
        return response([
            'data' => $news
        ]);
    }
}
