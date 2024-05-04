<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'name', 'short_description', 'long_description', 'path'];
    public static function createPhoto($file, $newsId) {
        $photo = News::where('id', $newsId)->first();
    // Генерируем уникальное имя для файла
    $fileName = $newsId . '_' . time() . '.' . $file->getClientOriginalExtension();

    // Проверяем, существует ли файл с таким именем
    $i = 1;
    while (Storage::exists('public/News/' . $newsId . '/' . $fileName)) {
        $fileName = $newsId . '_' . time() . "_$i." . $file->getClientOriginalExtension();
        $i++;
    }
    // Сохраняем файл в папку public/storage/News/news_id/filename
    $filePath = $file->storeAs('public/News/' . $newsId, $fileName);
    $pathBd = 'News/' . $newsId. '/'. $fileName;

    // Создаем запись о фото в базе данных
    $photo->path = $pathBd;
    $photo->save();
    }

}
