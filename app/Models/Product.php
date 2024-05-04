<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'quantity', 'category_id', 'path'];
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function compounds()
    {
        return $this->hasMany(Compound::class);
    }
    public static function createPhoto($file, $productId) {
        $photo = Product::where('id', $productId)->first();
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
        $photo->path = $pathBd;
        $photo->save();
    }
}
