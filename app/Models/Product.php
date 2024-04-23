<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'quantity', 'category_id'];
    public function categories()
    {
        return $this->belongsTo(Category::class, 'product_id');
    }
    public function photo_products()
    {
        return $this->hasMany(PhotoProduct::class);
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
}
