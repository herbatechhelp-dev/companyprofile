<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'article_category_id',
        'thumbnail',
        'content',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Scope untuk artikel yang sudah publish
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    // Scope untuk semua artikel (termasuk yang belum publish) - untuk admin
    public function scopeWithDrafts($query)
    {
        return $query;
    }

    // Cek apakah artikel sudah publish
    public function isPublished()
    {
        return $this->published_at && $this->published_at <= now();
    }

    // Relasi ke ArticleImage
    public function images()
    {
        return $this->hasMany(ArticleImage::class)->orderBy('order');
    }

    // Relasi ke ArticleCategory
    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }
}