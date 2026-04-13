<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'items',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'items'     => 'array',
        'is_active' => 'boolean',
    ];
}
