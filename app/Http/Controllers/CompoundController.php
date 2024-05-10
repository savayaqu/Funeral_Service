<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Compound;
use Illuminate\Http\Request;

class CompoundController extends Controller
{
    public function show(int $orderId) {
        $compound = Compound::where('order_id', $orderId)->get();
        if($compound->isEmpty()) {
            throw new  ApiException(404, 'Не найдено');
        }
        return response()->json(['data' => $compound])->setStatusCode(200);
    }
}
