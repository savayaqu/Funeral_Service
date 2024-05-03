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
    //Просмотр всех фото конкретной новости
    public function showPhotos(int $id) {
        $photos = PhotoNews::where('news_id', $id)->get();
        if($photos->isEmpty()) {
            throw new ApiException(404, 'Не найдено');
        }
        return response()->json(['data' => $photos])->setStatusCode(200);
    }
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
    // Добавление фото к новости
    public function createPhoto(CreatePhotoNewsRequest $request) {
        $photos = NewsController::createPhoto($request->file('path'), $request->input('news_id'));
        return response()->json(['message' => 'Фото успешно добавлены', 'data' => $photos])->setStatusCode(201);
    }
    public function createNews(CreateNewsRequest $request) {
        $news = new News($request->all());
        $news->save();
        if ($request->hasFile('path')) {
            $photo = PhotoNews::createPhoto($request->file('path'), $news->id);
        }
        return response()->json(['message' => 'Товар создан', 'dataProduct' => $news, 'dataPhoto' => $photo])->setStatusCode(201);
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
    // Обновление фото
    public function updatePhoto(UpdatePhotoNewsRequest $request, int $photoId) {
        // Получаем фотографию для обновления
        $newsId = $request->input('news_id');
        $photo = PhotoNews::find($photoId);
        if (!$photo) {
            throw new ApiException(404, 'Не найдено');
        }
        // Получаем новость, связанную с этой фотографией
        $news = News::find($photo->news_id);
        if (!$news) {
            throw new ApiException(404, 'Не найдено');
        }
        // Получаем файл из запроса
        $file = $request->file('path');
        if (!$file) {
            throw new ApiException(400, 'Некорректный запрос');
        }
        // Генерируем уникальное имя для файла
        $fileName = $news->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        // Удаляем старый файл
        Storage::delete($photo->path);
        // Сохраняем новый файл, заменяя старый
        $filePath = $file->storeAs('public/News/' . $newsId, $fileName);
        $pathBd = 'News/' . $newsId. '/'. $fileName;
        // Обновляем запись о фотографии в базе данных
        $photo->path = $pathBd;
        $photo->save();
        return response()->json(['message' => 'Фото обновлено', 'data' => $photo])->setStatusCode(200);
    }
    // Удаление записи о фото
    public function deletePhoto(int $photoId)
    {
        $photo = PhotoNews::find($photoId);
        if (!$photo) {
            throw new ApiException(404, 'Не найдено');
        }
        Storage::delete('public/'.$photo->path);
        $photo->delete();
        return response()->json(['message' => 'Фото удалено'])->setStatusCode(200);
    }
}
