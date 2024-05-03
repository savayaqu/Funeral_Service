<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PhotoNews extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'news_id'];
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }
    public static function createPhoto($files, $newsId) {
        // Получаем файлы из запроса
        $photos = [];

        // Итерируемся по каждому файлу
        foreach ($files as $file) {
            // Генерируем уникальное имя для файла
            $fileName = $newsId . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Проверяем, существует ли файл с таким именем
            $i = 1;
            while (Storage::exists('public/News/' . $newsId . '/' . $fileName)) {
                $fileName = $newsId . '_' . time() . "_$i." . $file->getClientOriginalExtension();
                $i++;
            }

            // Сохраняем файл в папку public/storage/Product/product_id/filename
            $filePath = $file->storeAs('public/News/' . $newsId, $fileName);
            $pathBd = 'News/' . $newsId. '/'. $fileName;

            // Создаем запись о фото в базе данных
            $photo = new PhotoNews([
                'path' => $pathBd,
                'product_id' => $newsId,
            ]);
            $photo->save();

            // Добавляем созданную запись в массив
            $photos[] = $photo;
        }

        return $photos;
    }
}
