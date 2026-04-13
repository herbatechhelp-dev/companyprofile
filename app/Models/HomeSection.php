<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'title',
        'content',
        'video_url',
        'background_image',
        'background_video',
        'is_active'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSection($query, $section)
    {
        return $query->where('section', $section);
    }
}