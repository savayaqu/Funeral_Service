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
        $this->belongsTo(Category::class);
    }
    public function photo_products()
    {
        $this->hasMany(Photo_Product::class);
    }
    public function reviews()
    {
        $this->hasMany(Review::class);
    }
    public function carts()
    {
        $this->hasMany(Cart::class);
    }
    public function compounds()
    {
        $this->hasMany(Compound::class);
    }
}
