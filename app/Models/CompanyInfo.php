<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'title',
        'description',
        'banner_image',
        'icons'
    ];

    protected $casts = [
        'icons' => 'array',
    ];

    // Accessor untuk icons yang aman
    public function getIconsAttribute($value)
    {
        $icons = json_decode($value, true);
        return is_array($icons) ? $icons : [];
    }
}