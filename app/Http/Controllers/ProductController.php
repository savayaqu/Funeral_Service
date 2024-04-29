<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\CreatePhotoProductRequest;
use App\Http\Requests\UpdatePhotoProductRequest;
use App\Models\Product;
use App\Models\PhotoProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //Просмотр всех фото конкретного товара
    public function showPhotos(int $id) {
        $photos = PhotoProduct::where('product_id', $id)->get();
        if($photos->isEmpty()) {
            throw new ApiException(404, 'Не найдено');
        }
        return response()->json(['data' => $photos])->setStatusCode(200);
    }
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
    // Добавление фото к товару
    public function createPhoto(CreatePhotoProductRequest $request) {
        // Получаем новость, к которой нужно добавить фото
        $productId = $request->input('product_id');
        $product = Product::find($productId);
        if (!$product) {
            throw new ApiException(404, 'Не найдено');
        }
        // Получаем файл из запроса
        $file = $request->file('path');
        // Генерируем уникальное имя для файла
        $fileName = $productId . '_' . time() . '.' . $file->getClientOriginalExtension();
        // Сохраняем файл в папку public/storage/Product/product_id/filename
        $filePath = $file->storeAs('public/Product/' . $productId, $fileName);
        $pathBd = 'Product/' . $productId. '/'. $fileName;
        // Создаем запись о фото в базе данных
        $photo = new PhotoProduct([
            'path' => $pathBd,
            'product_id' => $productId,
        ]);
        $photo->save();
        return response()->json(['message' => 'Фото успешно добавлено', 'data' => $photo])->setStatusCode(201);
    }
    // Обновление фото
    public function updatePhoto(UpdatePhotoProductRequest $request, int $photoId) {
        // Получаем фотографию для обновления
        $productId = $request->input('product_id');
        $photo = PhotoProduct::find($photoId);
        if (!$photo) {
            throw new ApiException(404, 'Не найдено');
        }
        // Получаем новость, связанную с этой фотографией
        $product = Product::find($photo->product_id);
        if (!$product) {
            throw new ApiException(404, 'Не найдено');
        }
        // Получаем файл из запроса
        $file = $request->file('path');
        if (!$file) {
            throw new ApiException(400, 'Некорректный запрос');
        }
        // Генерируем уникальное имя для файла
        $fileName = $product->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        // Удаляем старый файл
        Storage::delete($photo->path);
        // Сохраняем новый файл, заменяя старый
        $filePath = $file->storeAs('public/Product/' . $productId, $fileName);
        $pathBd = 'Product/' . $productId. '/'. $fileName;

        // Обновляем запись о фотографии в базе данных
        $photo->path = $pathBd;
        $photo->save();
        return response()->json(['message' => 'Фото обновлено', 'data' => $photo])->setStatusCode(200);
    }
    // Удаление записи о фото
    public function deletePhoto(int $photoId)
    {
        $photo = PhotoProduct::find($photoId);
        if (!$photo) {
            throw new ApiException(404, 'Не найдено');
        }
        Storage::delete('public/'.$photo->path);
        $photo->delete();
        return response()->json(['message' => 'Фото удалено'])->setStatusCode(200);
    }
}
