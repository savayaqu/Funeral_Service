<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'name', 'short_description', 'long_description'];
    public function photo_news()
    {
        $this->hasMany(Photo_News::class);
    }
}
