<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\CreateReviewRequest;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index() {
        $reviews = Review::all();
        return response()->json(['data' => $reviews])->setStatusCode(200);
    }
    public function show(int $id) {
        $reviews = Review::where('product_id', $id)->get();
        if (!$reviews) {
            throw  new ApiException(404, 'Не найдено');
        }
        return response()->json(['data' => $reviews])->setStatusCode(200);
    }
    public function createReview(CreateReviewRequest $request, int $productId) {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->whereHas('compounds', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })->first();
        if(!$order) {
            throw new ApiException(404, 'Не найдено');
        }
        $existsReview = Review::where('user_id', $user->id)->where('product_id', $productId)->exists();
        if($existsReview) {
            throw new ApiException(423, 'Заблокировано');
        }
        $review = new Review([
            'rating' => $request->input('rating'),
            'description' => $request->input('description'),
            'user_id' => $user->id,
            'product_id' => $productId
        ]);
        $review->save();
        return response()->json(['message' => 'Отзыв успешно сохранен'])->setStatusCode(201);
    }
}
