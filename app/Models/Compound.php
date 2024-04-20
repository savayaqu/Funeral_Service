<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compound extends Model
{
    use HasFactory;
    protected $fillable = ['quantity', 'total_price', 'order_id', 'product_id'];
    public function orders()
    {
        $this->belongsTo(Order::class);

    }
    public function products()
    {
        $this->belongsTo(Product::class);
    }
}
