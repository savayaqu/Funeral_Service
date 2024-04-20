<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo_News extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'news_id'];
    public function news()
    {
        $this->belongsTo(News::class);
    }
}
