<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\CreatePhotoNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Requests\UpdatePhotoNewsRequest;
use App\Models\News;
use App\Models\PhotoNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    //Метод просмотра всех новостей
    public function index() {
        $news = News::all();
        if($news->isEmpty()) {
            throw new ApiException(404, 'Не найдено');
        } else {
            return response([
                'data' => $news,
            ]);
        }
    }
    //Метод просмотра конкретной новости
    public function show(int $id) {
        $news = News::where('id', $id)->first();
        if(!$news) throw new ApiException(404, 'Не найдено');
        return response([
            'data' => $news
        ]);
    }
    // Создание новости
    public function createNews(CreateNewsRequest $request) {
        $news = new News($request->except('path'));
        $news->save();
        if ($request->hasFile('path')) {
           News::createPhoto($request->file('path'), $news->id);
        }
        return response()->json(['message' => 'Новость создана', 'dataNews' => $news])->setStatusCode(201);
    }
    // Обновление новости
    public function updateNews(UpdateNewsRequest $request, int $id) {
        $news = News::where('id', $id)->first();
        if(!$news) {
            throw new ApiException(404, 'Не найдено');
        }
        $news->fill($request->except('path'));
        $news->save();
        if ($request->hasFile('path')) {
            News::createPhoto($request->file('path'), $news->id);
        }
        return response()->json(['message'=> 'Новость '. $id .' обновлена'])->setStatusCode(200);
    }
    // Удаление новости
    public function deleteNews(int $id) {
        $news = News::where('id', $id)->first();
        if(!$news) {
            throw new ApiException(404, 'Не найдено');
        }
        $news->delete();
        return response()->json(['message'=> 'Новость '. $id .' удалена'])->setStatusCode(200);
    }

}
