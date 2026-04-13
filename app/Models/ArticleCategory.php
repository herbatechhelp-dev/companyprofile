<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug',
        'banner_image',
        'banner_video',
        'banner_title',
        'banner_content'
    ];
}
