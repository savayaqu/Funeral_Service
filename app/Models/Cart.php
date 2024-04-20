<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['quantity', 'user_id', 'product_id'];
    public function users()
    {
        $this->belongsTo(User::class);
    }
    public function products()
    {
        $this->belongsTo(Product::class);
    }
}
