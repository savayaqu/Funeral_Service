<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo_Product extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'product_id'];
    public function products()
    {
        $this->belongsTo(Product::class);
    }
}
