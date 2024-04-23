<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\CreatePhotoNewsRequest;
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
    // Добавление фото к новости
    public function createPhoto(CreatePhotoNewsRequest $request) {
        // Получаем новость, к которой нужно добавить фото
        $newsId = $request->input('news_id');
        $news = News::find($newsId);
        if (!$news) {
            throw new ApiException(404, 'Не найдено');
        }
        // Получаем файл из запроса
        $file = $request->file('path');
        // Генерируем уникальное имя для файла
        $fileName = $newsId . '_' . time() . '.' . $file->getClientOriginalExtension();
        // Сохраняем файл в папку public/storage/News/news_id/filename
        $filePath = $file->storeAs('public/News/' . $newsId, $fileName);
        $filePathForBD = '/public/storage/News/'. $newsId.'/'. $fileName;
        // Создаем запись о фото в базе данных
        $photo = new PhotoNews([
            'path' => $filePathForBD,
            'news_id' => $newsId,
        ]);
        $photo->save();
        return response()->json(['message' => 'Фото успешно добавлено', 'data' => $photo])->setStatusCode(201);
    }
    public function updatePhoto(UpdatePhotoNewsRequest $request, int $photoId) {
        // Получаем фотографию для обновления
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
        throw new ApiException(400, $photo->path);
        Storage::delete($photo->path);
        // Сохраняем новый файл, заменяя старый
        $filePath = $file->storeAs('public/News/' . $news->id, $fileName);



        // Обновляем запись о фотографии в базе данных
        $photo->path = '/public/storage/News/' . $news->id . '/' . $fileName;
        $photo->save();

        return response()->json(['message' => 'Фото успешно обновлено', 'data' => $photo])->setStatusCode(200);
    }
}
