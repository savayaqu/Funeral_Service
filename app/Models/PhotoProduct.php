<?php

namespace App\Models;

use App\Http\Requests\CreatePhotoProductPhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PhotoProduct extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'product_id'];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public static function createPhoto($files, $productId) {
        // Получаем файлы из запроса
        $photos = [];

        // Итерируемся по каждому файлу
        foreach ($files as $file) {
            // Генерируем уникальное имя для файла
            $fileName = $productId . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Проверяем, существует ли файл с таким именем
            $i = 1;
            while (Storage::exists('public/Product/' . $productId . '/' . $fileName)) {
                $fileName = $productId . '_' . time() . "_$i." . $file->getClientOriginalExtension();
                $i++;
            }

            // Сохраняем файл в папку public/storage/Product/product_id/filename
            $filePath = $file->storeAs('public/Product/' . $productId, $fileName);
            $pathBd = 'Product/' . $productId. '/'. $fileName;

            // Создаем запись о фото в базе данных
            $photo = new PhotoProduct([
                'path' => $pathBd,
                'product_id' => $productId,
            ]);
            $photo->save();

            // Добавляем созданную запись в массив
            $photos[] = $photo;
        }

        return $photos;
    }


}
