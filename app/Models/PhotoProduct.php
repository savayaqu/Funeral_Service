<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoProduct extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'product_id'];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
